# Remove images and css and js files access
# Then get last 10k lines
# Then remove unnecessary spaces to make sure the link is at 7th position in a line
# Then remove query string from ?
# Then set the link of each access at 7th position by awk
# Then use sort and uniq to get the ranking
zgrep -v ".png" $1  | grep -v ".jpg" | grep -v "jpeg" | grep -v ".css" | grep -v ".js" | grep -v ".ico" | grep -v ".gif" \
  | tail -n 10000 \
  | sed 's/, /,/g' \
  | awk '{print $7}' \
  | sed 's/\?.*//' \
  | sort | uniq -c | sort -nr | awk -v 'OFS=,' '{print $1,$2}'
