<?php
echo "source {$service['source_name']}
{
    type            = {$service['source_type']}
    sql_host        = {$service['sql_host']}
    sql_user        = {$service['sql_user']}
    sql_pass        = {$service['sql_pass']}
    sql_db          = {$service['sql_db']}
    sql_port        = {$service['sql_port']}

    sql_query_pre   = SET NAMES {$service['sql_charset']}
}\n\n";

for($i = 0; $i < $service['source_number']; $i++) {
   echo "source {$plainIndex['name']}_{$i}:{$service['source_name']}
{

    sql_query       = {$sqlQuery} from {$service['sql_table']}_{$i} {$sqlCondition}\n";
    echo $sqlJoinedField ? "sql_joined_field = {$sqlJoinedField}\n" : "\n";

    echo $columns;
    
echo "}\n\n";
}

if(count($plainIndex)) {

    echo "index {$plainIndex['name']} {
    path            = {$sphinxPath}/var/data/{$service['name']}/{$plainIndex['name']}
    
    docinfo         = extern
    
    #charset_type    = utf-8

	min_word_len = 1

    charset_table   = {$charsetTable}

	min_infix_len   = 1

    ngram_len       = 1

    ngram_chars     = {$ngramChars} \n";
    for($i = 0; $i < $service['source_number']; $i++) {
        echo "    source   = {$plainIndex['name']}_{$i}\n";
    }

echo "}\n\n";
}

if(isset($rtIndex)) {

echo "index {$rtIndex['name']} {
    type            = rt
    path            = {$sphinxPath}/var/data/{$service['name']}/{$rtIndex['name']}
    rt_mem_limit    = 2048M

{$rtColumns}

    docinfo         = extern
    #charset_type    = utf-8

    charset_table   = {$charsetTable}

    ngram_len       = 1

    ngram_chars     = {$ngramChars}
}\n\n";
}

echo "indexer
{
    mem_limit       = 1024M
}\n\n";

echo "searchd
{
    listen          = {$searchd['sphinx_listen']}

    listen          = {$searchd['mysql_listen']}:mysql41

    log             = {$sphinxPath}/var/log/searchd.log

    query_log       = {$sphinxPath}/var/log/query.log

    read_timeout    = {$searchd['read_timeout']}

    client_timeout  = {$searchd['client_timeout']}

    max_children    = 0

    pid_file        = {$sphinxPath}/var/log/searchd.pid

    binlog_path     = {$sphinxPath}/var/data/{$service['name']}

    seamless_rotate = 1

    preopen_indexes = 1

    unlink_old      = 1

    mva_updates_pool = 1M

    max_packet_size = 8M

    max_filters     = 256

    max_filter_values = 4096

    max_batch_queries = 32

    workers         = threads
}";
