<?php 

if(!isset($resumo['data']) && empty($resumo['data'])){
    echo "<div class='alert alert-danger '>Nenhum dado disponível. <a href='/home' class='alert-link'>Voltar</a></div>";
    return;
}

$dados = $resumo['data'];
?>
<div class="container-tight py-4" style="max-width: 550px; margin: 0 auto;">

    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle pulse-hover">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 2px; color: var(--brand-green);">Evolução</span>
        <div style="width: 40px;"></div>
    </div>

    <div class="card portal-card border-0 shadow-lg mb-4 overflow-hidden animate-in" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); position: relative;">
        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(var(--tblr-success-rgb), 0.15); filter: blur(40px); border-radius: 50%;"></div>
        
        <div class="card-body p-4 text-center position-relative">
            <div class="text-white-50 small text-uppercase mb-2 brand-orbitron" style="font-size: 0.7rem;">Pontuação Acumulada</div>
            <?php
            // aqui precisa validar se o XP existe, se não existir, consideramos 0 para evitar erros
            if (!isset($dados['xp_total'])) {
                $dados['xp_total'] = 0;
            }

            $xp = (int)$dados['xp_total'];

            // 1. Definimos o "teto" das barras baseado no XP
            // Se o XP for 10, o teto é baixo. Se for 2500+, o teto é 100.
            // A fórmula abaixo garante que o teto suba, mas nunca ultrapasse 100.
            $teto_maximo = min(100, 40 + ($xp / 50)); 

            // 2. Função rápida para gerar a altura randômica dentro do limite
            function gerarAltura($teto) {
                // Sempre acima de 30%, e no máximo o teto calculado pelo XP
                return rand(30, max(31, $teto));
            }
            ?>

            <div class="display-4 font-weight-bold text-white mb-2 counter-up"><?= $xp ?> <small class="text-success">XP</small></div>

            <div class="d-flex align-items-end justify-content-center gap-1 mt-3" style="height: 40px;">
                <?php 
                // Criamos as 7 barras com a lógica randômica baseada no XP
                for ($i = 0; $i < 7; $i++): 
                    $h = gerarAltura($teto_maximo);
                
                ?>
                    <div class="bg-success rounded-top bar-anim" 
                        style="width: 6px; --h: <?= $h ?>%; height: <?= $h ?>%; transition: height 0.3s ease;">
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="space-y-3 px-1">
        <?php 
        // aqui se nao existe historico, exibe uma mensagem amigavel
        if (empty($dados['treinos'])) {
            echo "<div class='alert alert-info'>Nenhum registro encontrado. <a href='/home' class='alert-link'>Voltar</a></div>";
            return;
        }

        foreach ($dados['treinos'] as $key => $value) { 
        $data_bruta = $value['initial_date'];
        $date = new DateTime($data_bruta);

        // 1. Pegar apenas o dia
        $dia = $date->format('d');

        // 2. Pegar o mês abreviado (Tradução manual para garantir 100% o PT-BR)
        $meses = [
            1 => 'JAN', 2 => 'FEV', 3 => 'MAR', 4 => 'ABR', 5 => 'MAI', 6 => 'JUN',
            7 => 'JUL', 8 => 'AGO', 9 => 'SET', 10 => 'OUT', 11 => 'NOV', 12 => 'DEZ'
        ];
        $mes_num = (int)$date->format('m');
        $mes_abrev = $meses[$mes_num];  

        $div_xp = "<div class=\"text-success small font-weight-bold\">🔥 +".$value['xp']." XP Conquistados</div>";
        $saldoio = '';
        // se o nome do treino for 'XP_IO_S' deve gerar um card generico, para mostrar que foi retirado o valor de XP (tipo um extrato bancario), da mesma forma para o 'XP_IO_E', s´que esse é uma entrada de saldo.
        if($value['name_training'] == 'XP_IO_S'){     
            $saldoio = 'S';      
            $value['name_training'] = 'Ajuste de Saldo';           
            $div_xp = "<div class=\"text-danger small font-weight-bold\"> -".$value['xp']." XP retirados</div>";        
        } elseif($value['name_training'] == 'XP_IO_E'){
            $saldoio = 'S';  
            $value['name_training'] = 'Ajuste de Saldo';
            $div_xp = "<div class=\"text-success small font-weight-bold\"> +".$value['xp']." XP recebidos</div>";
        }

        // aqui para baixo deve gerar o card em html para impressão caso for os 2 casos acima        
        ?>       

        <div class="training-card shadow-sm animate-in-up" style="animation-delay: <?= $i * 0.1 ?>s;" onclick="this.classList.toggle('expanded')">
            <div class="card-body p-3">
                
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <div class="text-center p-2 rounded-3 date-box">
                            <div class="small text-muted text-uppercase" style="font-size: 0.6rem;"><?= $mes_abrev ?></div>
                            <div class="h3 m-0"><?= $dia ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="font-weight-bold h4 mb-0 text-uppercase brand-orbitron"><?= $value['name_training'] ?></div>
                        <?= $div_xp ?>
                    </div>
                    <div class="col-auto text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="chevron-icon"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                </div>

                <div class="expandable-content mt-3 pt-3 border-top border-dashed">
                    
                    <?php 
                    if($saldoio == 'S'){
                       echo "<div class='alert alert-info'>".$value['obs']."</div>";
                    }

                    foreach ($value['exercises'] as $key => $ex) 
                    {  
                        $dados_limpos = array_filter(array_map('array_filter', $ex['executions'])); // Remove execuções vazias

                        if(empty($dados_limpos)){
                            continue; // Pula exercícios sem execuções válidas
                        }
                        
                    ?>
                    <div class="exercise-session p-2 rounded-3 mb-3" style="background: rgba(255,255,255,0.02);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-success-lt p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="text-success" fill="currentColor" viewBox="0 0 16 16"><path d="M1 8a7 7 0 1 1 14 0A7 7 0 0 1 1 8m10.354-3.646a.5.5 0 0 0-.708 0L7 8.293 5.354 6.646a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l4-4a.5.5 0 0 0 0-.708"/></svg>
                                </div>
                                <span class="font-weight-bold brand-orbitron" style="font-size: 0.8rem;"><?= $ex['name_exercise'] ?></span>
                            </div>
                            <span class="text-muted extra-small">Meta: <?= $ex['meta'] ?></span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead>
                                    <tr class="text-muted extra-small uppercase">
                                        <th style="width: 20%;">Série</th>
                                        <th class="text-center">Peso/Tempo</th>
                                        <th class="text-end">Reps</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($ex['executions'] as $key => $set) 
                                    {
                                    ?>
                                    <tr>
                                        <td><span class="badge">S<?= $set['serie'] ?></span></td>
                                        <td class="text-center small"><?= $set['peso'].' '.$ex['unit'] ?></td>
                                        <td class="text-center small"><?= $set['reps'] ?> reps</td>
                                    </tr>
                                    <?php } ?>                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } 
                    
                    if($saldoio <> 'S'){                  
                    ?>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 p-2 bg-dark-lt rounded-2">
                        <span class="extra-small text-muted">Esforço Total</span>
                        <span class="font-weight-bold text-success" style="font-size: 0.75rem;">CARGA: <?= $value['total_load'] ?> KG</span>
                        <span class="font-weight-bold text-success" style="font-size: 0.75rem;">CARDIO: <?= $value['total_minutes'] ?> MIN</span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<style>
    /* Estilos Gerais de Animação e Identidade*/
    .brand-orbitron { font-family: 'Orbitron', sans-serif; }
    .animate-in { animation: scaleIn 0.5s ease-out; }
    .animate-in-up { opacity: 0; animation: slideUp 0.6s forwards; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .bar-anim { height: 0; animation: barGrow 1s forwards; animation-delay: 0.5s; }
    @keyframes barGrow { from { height: 0; } to { height: var(--h); } }

    .training-card { background: var(--tblr-bg-surface); border-radius: 16px; border: 1px solid var(--tblr-border-color); cursor: pointer; transition: 0.3s; }
    .training-card.expanded { border-color: var(--brand-green); }
    
    .expandable-content { display: none; animation: fadeIn 0.3s ease; }
    .training-card.expanded .expandable-content { display: block; }
    .training-card.expanded .chevron-icon { transform: rotate(180deg); color: var(--brand-green); }

    .bg-dark-lt { background: #1e293b !important; color: #fff; border: 1px solid rgba(255,255,255,0.05); }
    .date-box { background: rgba(var(--tblr-secondary-rgb), 0.05); border: 1px solid var(--tblr-border-color); min-width: 52px; }
    .extra-small { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .table-sm td { padding: 0.6rem 0; vertical-align: middle; }
    .chevron-icon { transition: transform 0.3s ease; }
</style>