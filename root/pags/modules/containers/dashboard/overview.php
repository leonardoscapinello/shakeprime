<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget">
            <h3 style="font-size:1.4em;">Total em Vendas Abertas do Mês</h3>
            <div style="font-size:2.5em;color:white;margin:13px 0;font-weight:400;">
                R$ <?= $number->singleMoney($salesDashboard->getTotalSalesNotFinished()) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget">
            <h3 style="font-size:1.4em;">Total em Vendas Finalizadas do Mês</h3>
            <div style="font-size:2.5em;color:white;margin:13px 0;font-weight:400;">
                R$ <?= $number->singleMoney($salesDashboard->getTotalSalesFinished()) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget">
            <h3 style="font-size:1.4em;">Pontos de Volume</h3>
            <div style="font-size:2.5em;color:white;margin:13px 0;font-weight:400;">
                PV <?= $salesDashboard->getTotalVolumeFinished() ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-xl-3">
        <div class="widget">
            <h3 style="font-size:1.4em;">Lucro do Mês</h3>
            <div style="font-size:2.5em;color:white;margin:13px 0;font-weight:400;">R$ 2.567.597,22</div>
        </div>
    </div>
</div>