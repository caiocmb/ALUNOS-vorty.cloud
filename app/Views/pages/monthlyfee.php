<div class="container-tight py-4" style="max-width: 550px; margin: 0 auto;">

    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 1px; color: var(--brand-green);">Mensalidades</span>
        <div style="width: 40px;"></div>
    </div>



    <div class="space-y-2">

        <?php 
        if($mensalidades['status']=='error')
        {
            echo '<div class="alert alert-danger d-flex align-items-center gap-2 mb-0" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm3.536-9.536a.5.5 0 1 1-.707-.707L10.293 8l-2.147-2.146a.5.5 0 1 1 .707-.707L11 7.293l2.146-2.147z"/>
                    </svg>
                    <div>
                        '.$mensalidades['message'].'
                    </div>
                </div>';
        }
        else 
        {
            foreach($mensalidades['data'] as $mensalidade)
            {
                switch ($mensalidade['status']) {
                    case 'Aguardando':
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
                        break;
                    case 'Vencido':
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
                        break;
                    case 'Pago':
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>';
                        break;
                    case 'Valores Pendentes':
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-square-rounded"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>';
                        break;
                    case 'Cancelado':
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                        break;
                    default:
                        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';
                        break;
                }

                echo '<div class="card portal-card border-0 shadow-sm" style="background: var(--tblr-bg-surface);">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar rounded-circle '.$mensalidade['color'].'">
                                        '.$icon.'
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium text-capitalize">'.$mensalidade['month'].'</div>
                                    <div class="text-muted small">'.$mensalidade['description'].'</div>
                                </div>
                                <div class="col-auto text-end">
                                    <span class="badge '.$mensalidade['color'].' mb-1">'.$mensalidade['status'].'</span>
                                    <div class="font-weight-bold small">R$ '.number_format($mensalidade['value'], 2, ',', '').'</div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        }
        ?>


    </div>
</div>
