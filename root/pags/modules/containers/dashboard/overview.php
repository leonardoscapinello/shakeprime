<?php
$past_month_0 = $salesDashboard->getTotalFromPastMonth(0);
$past_month_1 = $salesDashboard->getTotalFromPastMonth(1);
$past_month_2 = $salesDashboard->getTotalFromPastMonth(2);
$past_month_3 = $salesDashboard->getTotalFromPastMonth(3);
$past_month_4 = $salesDashboard->getTotalFromPastMonth(4);
$past_month_5 = $salesDashboard->getTotalFromPastMonth(5);

$profit = intval($past_month_0['profit']);
$final_price = intval($past_month_0['final_price']);

?>
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Total em Vendas Abertas do Mês</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                R$ <?= $number->singleMoney($salesDashboard->getTotalSalesNotFinished()) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Total em Vendas Finalizadas do Mês</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                R$ <?= $number->singleMoney($salesDashboard->getTotalSalesFinished()) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Lucro desse mês</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                R$ <?= $number->singleMoney($profit) ?>
            </div>
        </div>
    </div>
</div

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Lucratividade Média do Mês</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                <?php
                $percent = ($profit / $final_price) * 100;
                echo $number->singleMoney($percent) . "%";
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Taxa de Finalização das Vendas</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                <?= $number->singleMoney($salesDashboard->getConvertionRate()) ?>%
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-4">
        <div class="widget">
            <h3 style="font-size:1.4em;">Pontos de Volume do mês</h3>
            <div style="font-size:2.74em;color:white;margin:13px 0;font-weight:400;">
                PV <?= $salesDashboard->getTotalVolumeFinished() ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-6">
        <div class="widget">
            <canvas id="saleDiscount"></canvas>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-6">
        <div class="widget">
            <canvas id="salesProfit"></canvas>
        </div>
    </div>
</div>


<script type="text/javascript">
    var salesDiscount = document.getElementById('saleDiscount').getContext('2d');
    var chart = new Chart(salesDiscount, {
        type: 'line',
        data: {
            labels: [
                '<?=$salesDashboard->getMonthName(5)?>',
                '<?=$salesDashboard->getMonthName(4)?>',
                '<?=$salesDashboard->getMonthName(3)?>',
                '<?=$salesDashboard->getMonthName(2)?>',
                '<?=$salesDashboard->getMonthName(1)?>',
                '<?=$salesDashboard->getMonthName(0)?>'
            ],
            datasets: [{
                label: 'Valor registrado',
                backgroundColor: 'rgba(255, 99, 132, 0)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [
                    <?=$past_month_5['final_price']?>,
                    <?=$past_month_4['final_price']?>,
                    <?=$past_month_3['final_price']?>,
                    <?=$past_month_2['final_price']?>,
                    <?=$past_month_1['final_price']?>,
                    <?=$past_month_0['final_price']?>
                ]
            },
                {
                    label: 'Valor possível',
                    backgroundColor: 'rgba(54, 162, 235, 0)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: [
                        <?=$past_month_5['sale_price']?>,
                        <?=$past_month_4['sale_price']?>,
                        <?=$past_month_3['sale_price']?>,
                        <?=$past_month_2['sale_price']?>,
                        <?=$past_month_1['sale_price']?>,
                        <?=$past_month_0['sale_price']?>
                    ]
                }]
        },
        options: {}
    });
    var salesProfit = document.getElementById('salesProfit').getContext('2d');
    var chart2 = new Chart(salesProfit, {
        type: 'line',
        data: {
            labels: [
                '<?=$salesDashboard->getMonthName(5)?>',
                '<?=$salesDashboard->getMonthName(4)?>',
                '<?=$salesDashboard->getMonthName(3)?>',
                '<?=$salesDashboard->getMonthName(2)?>',
                '<?=$salesDashboard->getMonthName(1)?>',
                '<?=$salesDashboard->getMonthName(0)?>'
            ],
            datasets: [{
                label: 'Lucro',
                backgroundColor: 'rgba(255, 99, 132, 0)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [
                    <?=$past_month_5['profit']?>,
                    <?=$past_month_4['profit']?>,
                    <?=$past_month_3['profit']?>,
                    <?=$past_month_2['profit']?>,
                    <?=$past_month_1['profit']?>,
                    <?=$past_month_0['profit']?>
                ]
            },
                {
                    label: 'Vendas',
                    backgroundColor: 'rgba(54, 162, 235, 0)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    data: [
                        <?=$past_month_5['final_price']?>,
                        <?=$past_month_4['final_price']?>,
                        <?=$past_month_3['final_price']?>,
                        <?=$past_month_2['final_price']?>,
                        <?=$past_month_1['final_price']?>,
                        <?=$past_month_0['final_price']?>
                    ]
                }]
        },
        options: {}
    });
</script>