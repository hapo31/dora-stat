$(function(){
    $.ajax('api/stat', {
        type: 'get',
        data: {
            from: '2015-11',
            to:  '2016-09'
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
                    text: "2015-05 ~ 2016-09の期間中でドラえもんが性器を露出した回数"  //グラフタイトル
                },
                axisY: {
                    maximum: 30
                },
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