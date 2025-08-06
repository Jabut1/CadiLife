 <?php  
        session_start();
       
        if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.html');
            exit;
        }

        include_once('config.php');
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <title>Relatório de Saúde</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css?v=3">
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body bgcolor="#F0F8FF">
        <header>
            <div class="logo-container">
    <div class="logo-icon">
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="20" cy="20" r="18" fill="#0089e0" fill-opacity="0.2" stroke="#0089e0" stroke-width="2"/>
        <path d="M20 10V30M10 20H30" stroke="#0089e0" stroke-width="3" stroke-linecap="round"/>
      </svg>
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 20C10 13.3726 15.3726 8 22 8C28.6274 8 34 13.3726 34 20C34 26.6274 28.6274 32 22 32C15.3726 32 10 26.6274 10 20Z" fill="#005b96" fill-opacity="0.2" stroke="#005b96" stroke-width="2"/>
        <path d="M15 20H29M22 13V27" stroke="#005b96" stroke-width="3" stroke-linecap="round"/>
      </svg>
    </div>
                  <h1 class="logo"><span class="cadi"><h2>Cadi</h2></span><span class="life"><h2>Life</h2></span></h1>
               </div>

            <nav id="menu">
                <ul>
                    <li><a href="relatorio.php">Relatório</a></li>
                    <li><a href="plano.php">Plano</a></li>
                    <li><a href="resultados.php">Resultados</a></li>
                </ul>
            </nav>
        </header>
        <div id="texto" style="margin-left: 20px;">
        <h1 style="padding-top: 10px;">Plano que você pode seguir </h1> </br>
        <section>
            <h2>1. Aquecimento (5-10 minutos)</h2>
            <p>Antes de qualquer exercício, é importante realizar um aquecimento leve para preparar o corpo.</p>
            <ul>
                <li>Caminhada ou corrida leve (5-10 minutos)</li>
                <li>Movimentos articulares: Rotação de pescoço, ombros, quadris, joelhos e tornozelos.</li>
            </ul>
        </section>
        <section>
            <h2>2. Exercícios Aeróbicos (30 minutos, 3-4 vezes por semana)</h2>
            <p>Exercícios aeróbicos ajudam a melhorar a circulação sanguínea, controlar o peso e a glicose, além de reduzir a pressão arterial.</p>
            <ul>
                <li>Caminhada rápida ou corrida leve: 20-30 minutos em ritmo constante.</li>
                <li>Bicicleta ergométrica ou ciclismo ao ar livre: 20-30 minutos, 3 vezes por semana.</li>
                <li>Natação ou hidroginástica: Uma excelente opção para quem busca baixo impacto nas articulações.</li>
            </ul>
        </section>
        <section>
            <h2>3. Recomendações Nutricionais</h2>
            <ul>
                <li>Controle do consumo de sódio: Evite alimentos com alto teor de sal, como alimentos processados, enlatados e fast food.</li>
                <li>Frutas, legumes e grãos integrais: Consuma alimentos ricos em fibras para ajudar no controle de glicose e melhorar o trânsito intestinal.</li>
                <li>Proteínas magras: Inclua proteínas magras, como peixe, frango, ovos e leguminosas, em suas refeições.</li>
                <li>Hidratação: Beba água regularmente ao longo do dia (cerca de 2 litros de água por dia).</li>
            </ul>
        </section>
        <section>
            <h2>4. Qualidade do sono</h2>
            <ul>
                <li>Temperatura ideal: tente dormir entre 15°C em 19°C para uma melhor qualidade e conforto de sono</li>
                <li>Não coma antes de dormir: não consuma alimentos antes de dormir</li>
                <li>Desconecte-se das telas antes de dormir: A luz azul do celular e da TV atrasam a produção de melatonina. Desligue os aparelhos pelo menos 1 hora antes de deitar.</li>
                <li>Tenha horários regulares: dormir e acordar sempre nos mesmos horários ajuda seu corpo a entender quando é hora de desligar. A constância regula o relógio biológico.</li>
            </ul>
</main>
</body>
</html>


