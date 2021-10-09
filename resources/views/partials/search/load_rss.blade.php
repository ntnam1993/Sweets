<script>
    function showRss(urlRss) {
        $.ajax({
            url: urlRss,
            type: 'GET',
            success: function (data) {
                let arr = [], xml = $(data);
                xml.find("item").each(function() {
                    let $this = $(this),
                        item = {
                            title: $this.find("title").text(),
                            link: $this.find("link").text(),
                            description: $this.find("description").text(),
                            pubDate: $this.find("pubDate").text(),
                            author: $this.find("author").text(),
                            enclosure: $this.find("enclosure").attr('url')
                        };
                    arr.push(item);
                });

                let html = '';
                $.each(arr, function (key, value) {
                    let description = value.description;
                    description = description.replace(/(<([^>]+)>)/ig,"");

                    if (key < 5) {
                        html += '<li>';
                        html += '<a href="'+ value.link +'" target="_blank">';
                        html += '<img src="'+ value.enclosure +'" alt="">';
                        html += '<p>';
                        html += '<p class="text-150">'+ value.title +'</p>';
                        html += '<p class="3-lines dotdotdot is-truncated" style="height: 50px !important; overflow-wrap: break-word;">'+ description +'</p>';
                        html += '</p>';
                        html += '</a>';
                        html += '</li>';
                    }
                });

                // get link
                let link = '';
                xml.find("channel").each(function() {
                    let $this = $(this);
                    link = $this.find('link').first().text();
                });

                if (html)
                    html = '<ul class="ul-sidebar">' + html + '</ul>';

                if (html && link)
                    html += '<a href="'+ link +'" class="a-more" target="_blank">特集一覧へ</a>';

                if (html)
                    $('#rss').html(html);
                else
                    $('#rss').html('<p class="align-left">RSSフィードが取得できません</a></p>');
            },
            error: function (error) {
                // nothing
            },
            timeout: JAVASCRIPT_TIMEOUT_RSS
        });
    }
</script>