                <footer class="footer footer-transparent d-print-none">
                  <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                      <div class="col-lg-auto ms-lg-auto">
                        <ul class="list-inline list-inline-dots mb-0">
                          <li class="list-inline-item"><?= $_ENV['COMPANY_NAME']; ?></li> 
                          <?php 
                          $path = trim($_SERVER['REQUEST_URI'], '/');
                          $pagina = basename($path);
                          if($pagina == 'workout') {
                          ?>
                          <li class="list-inline-item">
                            <button class="btn btn-icon px-2" onclick="toggleTheme()" id="themeBtn"></button>
                          </li>  
                          <?php } ?>       
                        </ul>
                      </div>
                      <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                          <li class="list-inline-item">
                            <?= $_ENV['APP_VERSAO'] ?> Build <?= $_ENV['APP_BUILD'] ?>
                          </li>
                          <li class="list-inline-item">
                              <a href="https://vorty.cloud" target="_blank">vorty.cloud</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </footer>
            </div>
        </div>
    </div>
</div>

<!-- Libs JS -->
<!-- Tabler Core -->
<script src="/assets/js/tabler.min.js?<?= $_ENV['APP_VERSAO'] ?>" defer></script>
<script src="/assets/js/jquery-3.7.1.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
<script src="/assets/js/driver.js.iife.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
<script src="/assets/js_app/theme.js?<?= $_ENV['APP_VERSAO'] ?>"></script>
<script src="/assets/js/toastr.min.js?<?= $_ENV['APP_VERSAO'] ?>"></script>

<!-- ### Custom Scripts  ### -->
<?php 
$jsPath = __DIR__ . '/../../../public/assets/js_app/';
foreach ($js_config as $file) {
    if (file_exists($jsPath . $file)) {
        echo '<script src="/assets/js_app/' . $file . '?'.$_ENV['APP_VERSAO'].'"></script>' . PHP_EOL;
    }
}
?>


  </body>
</html>