$(function(){
    $.ajax('api/stat', {
        type: 'get',
        data: {
            from: '2015-10',
            to:  '2016-10'
        }
    }).then(
        function(jsonData) {
            var data = [];
            for(var i = 0; i < jsonData.length; ++i) {
                var row = jsonData[i];
                data.push({
                    label: row.date,
                    y: parseInt(row.boron_count)
                });
            }
            console.log(jsonData);
            var stage = document.getElementById('stage');
            var chart = new CanvasJS.Chart(stage, {
                title: {
                    text: "各月でドラえもんが性器を露出した回数"  //グラフタイトル
                },
                axisY: {
                    suffix: "回",
                    maximum: 30
                },
                axisX: {
                    lineThickness: 3,
                },
                animationEnabled: true,
                theme: "theme4",  //テーマ設定
                data: [{
                    type: 'column',  //グラフの種類
                    dataPoints: data  //表示するデータ
                }]
            });
            chart.render();
        }
    );
});