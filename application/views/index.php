<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ドラちゃんのおちんちん</title>
        <meta charset="UTF-8">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
            $(function(){ 
                //「月別データ」
                var data = [
                { label: "１月", y: 65 },
                { label: "２月", y: 59 },
                { label: "３月", y: 80 },
                { label: "４月", y: 81 },
                { label: "５月", y: 56 },
                { label: "６月", y: 55 },
                { label: "７月", y: 48 }
                ];

                var stage = document.getElementById('stage');
                var chart = new CanvasJS.Chart(stage, {
                title: {
                    text: "今月の露出数"  //グラフタイトル
                },
                theme: "theme4",  //テーマ設定
                data: [{
                    type: 'column',  //グラフの種類
                    dataPoints: data  //表示するデータ
                }]
                });
                chart.render();
            });
        </script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#patern02">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand">ドラえもんの性器露出回数統計</a>
                </div>

                <div id="patern02" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right active">
                    <li class="active"><a href="">今週</a></li>
                    <li class=""><a href="">今月</a></li>
                    <li class=""><a href="">合計</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="container">
            <div id="stage">

            </div>
        </div>
    </body>
</html>