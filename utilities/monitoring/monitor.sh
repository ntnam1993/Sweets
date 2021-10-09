send_alert_mail() {
time=$1
process_number=$2
cpu_usage=$3
memory_usage=$4

mail_from="Sweets Production Server"
mail_to="lam.phan.qg@neo-lab.co.jp, masatoshi.nagaoka@neo-lab.co.jp, 18a4ea3c.eparkinc.onmicrosoft.com@apac.teams.ms"
subject="Abnormal server load"

cat << EOD | sendmail -t
From: ${mail_from}
To: ${mail_to}
Subject: $subject}
Content-Type: text/plain;charset="UTF-8"

-----------------
Time: ${time}
HTTTPD Process Number: ${process_number} (Threshold: 50)
CPU Usage: ${cpu_usage}% (Threshold: 300%)
Memory Usage: ${memory_usage}% (Threshold: 20%)
-----------------

EOD
}

now=$(date +"%Y-%m-%d-%T")
cpu_memory=`(top -d 0 -n 1 -c -b; echo "";) | grep httpd | grep -v "grep" | awk -v 'OFS=,' '{a += $9;b += $10;} END {print a,b}'`
IFS=',' read -r -a cpu_memory_array <<< "$cpu_memory"
cpu=${cpu_memory_array[0]}
memory=${cpu_memory_array[1]}
process_number=`pgrep httpd | wc -l`
output="$now,$process_number,$cpu,$memory"
echo $output >> /var/www/html/sweets/current/storage/logs/monitor_log.csv

if [ "$process_number" -gt 50 ] || (( $(echo "$cpu > 300" | bc -l) )) || (( $(echo "$memory > 20" | bc -l) )); then
  send_alert_mail $now $process_number $cpu $memory
fi
