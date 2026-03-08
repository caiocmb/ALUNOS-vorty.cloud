<div class="container-tight py-4" style="max-width: 550px; margin: 0 auto;">

    <div class="d-flex align-items-center justify-content-between mb-4 px-2">
        <a href="/home/" class="btn btn-icon btn-ghost-secondary rounded-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <span class="brand-orbitron h4 m-0 text-uppercase" style="letter-spacing: 1px; color: var(--brand-green);">Ajustes</span>
        <div style="width: 40px;"></div>
    </div>

    <ul class="nav nav-pills nav-fill mb-4 p-1 rounded-3 mx-2" role="tablist" style="background: rgba(var(--tblr-card-bg), 0.1);">
        <li class="nav-item">
            <a class="nav-link active py-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="tab" href="#tab-perfil">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="small">Perfil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="tab" href="#tab-seguranca">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span class="small">Senha</span>
            </a>
        </li>
    </ul>

    <div class="tab-content mx-2">
        <div class="tab-pane fade show active" id="tab-perfil">
            <div class="card portal-card border-0 shadow-sm mb-4" style="background: var(--tblr-bg-surface);">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="d-inline-block position-relative">
                            <span id="avatar-preview" class="avatar avatar-xl rounded-circle avatar-glow" 
                                  style="width: 110px; height: 110px; border: 3px solid var(--tblr-border-color); background-image: url('/photo/profile/<?= $_SESSION['user_photo']; ?>')">
                            </span>
                            <label for="upload-photo" class="btn btn-icon btn-primary rounded-circle position-absolute bottom-0 end-0 shadow-lg" style="width: 36px; height: 36px; cursor: pointer; border: 2px solid var(--tblr-bg-surface);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                <input type="file" id="upload-photo" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase mb-2">Nome Social</label>
                        <input type="text" id="user_name" class="form-control" placeholder="Como quer ser chamado?" 
                               value="<?= $_SESSION['user_name']; ?>" 
                               style="background: transparent; border: 1px solid var(--tblr-border-color); height: 50px; border-radius: 10px;">
                    </div>

                    <button class="btn btn-success w-100 py-2 shimmer border-0 shadow-sm mt-3" id="btn-save-profile" style="border-radius: 10px; font-weight: 600; height: 50px;">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tab-seguranca">
            <div class="card portal-card border-0 shadow-sm mb-4" style="background: var(--tblr-bg-surface);">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase">Senha Atual</label>
                        <input type="password" id="current_password" class="form-control" style="background: transparent; border: 1px solid var(--tblr-border-color); height: 45px; border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted text-uppercase">Nova Senha</label>
                        <input type="password" id="new_password" class="form-control" style="background: transparent; border: 1px solid var(--tblr-border-color); height: 45px; border-radius: 10px;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted text-uppercase">Repetir Nova Senha</label>
                        <input type="password" id="confirm_password" class="form-control" style="background: transparent; border: 1px solid var(--tblr-border-color); height: 45px; border-radius: 10px;">
                    </div>
                    <button class="btn btn-outline-success w-100 py-2 border-2" id="btn-update-password" style="border-radius: 10px; font-weight: 600; height: 45px;">
                        Atualizar Senha
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

