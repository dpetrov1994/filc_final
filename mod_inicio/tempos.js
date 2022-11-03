/*
 *  Document   : compCalendar.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Calendar page
 */







function tempos_categoria() {
    $('#tempos_cat').html("<h3 class='text-center text-muted'><i class='fa fa-spin fa-spinner'></i><br> Aguarde..</h3>");
    var inicio=$("#inicio1").val();
    var fim=$("#fim1").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            $('#tempos_cat').html("<canvas id=\"mycanvas\"></canvas>");

            // create initial empty chart
            var ctx_live = document.getElementById("mycanvas");

            const DATA_COUNT = 5;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};
            const data = {
                labels: ['Red', 'Orange', 'Yellow'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [1,2,3],
                        backgroundColor: ['red','blue','green'],
                    }
                ]
            };

            var myChart = new Chart(ctx_live, {
                type: 'pie',
                data: JSON.parse(this.responseText),
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                }
            });

            myChart.update();
        }
    };
    xmlhttp.open("GET", "ajax/tempos_categoria.php?inicio=" + inicio+"&fim="+fim, true);
    xmlhttp.send();
}