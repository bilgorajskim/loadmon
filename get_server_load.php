<?php
function get_processor_cores_number() {
    $command = "cat /proc/cpuinfo | grep processor | wc -l";

    return  (int) shell_exec($command);
}
$cpu_cores = get_processor_cores_number();
set_time_limit(10);
exec('ps -aux', $processes);
	foreach($processes as $process){
        $cols = explode(' ', preg_replace("/ +/", ' ', $process));
        if (strpos($cols[2], '.') > -1){
            $cpuUsage += floatval($cols[2]);
        }
    }
    print(($cpuUsage / $cpu_cores));
	?>;<?php
function get_server_memory_usage(){
 
	$free = shell_exec('free');
	$free = (string)trim($free);
	$free_arr = explode("\n", $free);
	$mem = explode(" ", $free_arr[1]);
	$mem = array_filter($mem);
	$mem = array_merge($mem);
	$memory_usage = round($mem[2]/$mem[1]*100);
 
	return $memory_usage;
}
echo get_server_memory_usage();
	?>;<?php
	$load = ((float)sys_getloadavg()[0] / $cpu_cores) * 100;
	echo $load;
	?>