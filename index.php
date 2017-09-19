<?php
//PURPOSE: Redirect by browser language just once in session, so user doesn't get disturbed when browsing different language by free will
$sites = array(
    "es" => "es/",
    "en" => "en/",
);

// Get 2 char lang code
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

// Redirect to language versions when available and set cookie to prevent further redirection for one day
if (in_array($lang, array_keys($sites)) && (!isset($_COOKIE['UserLang']))) {
  header('Location: ' . $sites[$lang]);
  setcookie("UserLang", "Checked", time() + (86400 * 1), "/"); // 86400 sec = 1 day
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Dachdeckerei Frank Lipp</title>
	<meta name="language" content="de">
	<meta name="keywords" content="frank lipp, dachdecker, handwerker, dächer, mallorca, balearen" />
	<meta name="description" content="Dachdeckerei Frank Lipp und Söhne seit 2 Generationen auf Mallorca" />
	<meta name="page-topic" content="Bauen Wohnen">
	<link rel="canonical" href="http://www.dernaechsteregen.com">
	<meta property="og:locale" content="de_DE">
	<meta property="og:type" content="website">
	<meta property="og:title" content="">
	<meta property="og:image" content="http://www.dernaechsteregen.com/images/thumbs/01.jpg" />
	<meta property="og:description" content="Dachdeckerei Frank Lipp und Söhne seit 2 Generationen auf Mallorca">
	<meta property="og:url" content="http://www.dernaechsteregen.com">
	<meta property="og:site_name" content="Dachdeckerei Frank Lipp und Söhne">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery.fullPage.js"></script>
	<script type="text/javascript" src="assets/js/jquery.easings.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.poptrox.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<!-- MAIL FORM -->
    <?php
      include 'assets/mailform/common.php';
    ?>
    <link rel="stylesheet" type="text/css" href="assets/mailform/css/mailform.css" />
    <!-- link rel="stylesheet" type="text/css" href="assets/mailform/css/fancy-buttons.css" /-->
    <!-- script type="text/javascript" src="contact-app/js/jquery-1.11.2.min.js"></script-->
    <script type="text/javascript" src="assets/mailform/js/jquery-migrate.min.js"></script>
    <script type="text/javascript">
      <!--
      var acf_config_path = jQuery.parseJSON('<?php echo $func->DoJsonEncode($acf_config['path']); ?>');
      -->
    </script>
    <script type="text/javascript" src="<?php echo $acf_config['path']['form']; ?>assets/mailform/js/init.php?x=<?php echo $unique_id; ?>"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>

<body>
		<!-- Header -->
			<header id="header">				
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li data-menuanchor="intro" class="active"><a class="navi" href="#intro">Intro</a></li>
							<li data-menuanchor="services"><a class="navi" href="#services">Leistungen</a></li>
							<li data-menuanchor="more"><a class="navi" href="#more">Mehr</a></li>
							<li data-menuanchor="contact"><a class="navi" href="#contact">Kontakt</a></li>
						</ul>
					</nav>
				<!-- Logo -->
					<h1 id="logo">Dachdeckerei Frank Lipp</h1>			
			</header>
			<div id="fullpage" class="glass">
				<div id="section0" class="section main style1">
					<div class="slide" id="slide1">
						<div class="content container-fluid introheader">
								<header>							
									<div id="line">
										<img src="images/logo.png" title="Logo" alt="" />
										<div id="roof"></div>
									</div>							
									<h2>Der nächste Regen kommt bestimmt.</h2>
									<h3>Dachdeckerei Frank Lipp und Söhne - Montuiri Ihr Dach- und Fachbetrieb in der 2. Generation auf Mallorca</h3>
									<p>Unser Handwerksbetrieb berät Sie individuell in allen Fragen und löst mit seinen qualifizierten und zuverlässigen Mitarbeitern seriös auch schwierige Probleme an Ihrem Bauvorhaben.</p>
								</header>
						</div>
					</div>
					<div class="slide" id="slide2">
						<div class="content container-fluid introheader">
								<header>
									<div id="line">
										<img src="images/logo.png" title="Logo" alt="" />
										<div id="roof"></div>
									</div>
									<h2>Trocken vom Keller bis zum Dach.</h2>
									<p>Der Dachdeckerbetrieb wurde 1997 von mir auf Mallorca gegründet. Jahrelange Erfahrung, leistungsstarke Partnerschaften und unsere hohe Anpassungsfähigkeit<br>
									an die Anforderungen der heutigen Zeit, sowie die optimale Beratung und Betreuung unserer Kunden,<br>
									haben unser Unternehmen zu seiner heutigen Bedeutung geführt.</p>
								</header>
						</div>
					</div>
					<div class="arrow bounce"><a href="#services" class="nav-label"></a></div>
				</div>				
				<div id="section1" class="section main style2">
					<header>
						<h2>Unsere Leistungen</h2>
					</header>
						<div class="container">
							<div id="gallery" class="row images">
								<div class="col-sm-6 gallery">
									<header>
										<h3>Dachdeckerei</h3>
									</header>
									<a id="hover1" href="images/gallery/01.jpg" class="image left">
										<img src="images/thumbs/01.jpg" title="Wir können nicht alles, aber alles was wir können, können wir zuverlässig, qualifiziert und seriös." title="Dachdeckungen" alt="" />								
										<div id="panel1" class="hover"><p>Dach- Neu- u. Umdeckungen<br>Wärmedämmung<br>Flachdachabdichtung<br>Dachrinnen<br>Terrassenabdichtung<br>Maurerabdeckung<br></p></div>
									</a>
									<a href="images/gallery/02.jpg" class="image fit"><img title="Dach- Neu- u. Umdeckungen" alt="" /></a>
									<a href="images/gallery/03.jpg" class="image fit"><img title="Flachdachabdichtung mit Flüssigkustsoff" alt="" /></a>						
									<a href="images/gallery/04.jpg" class="image fit"><img title="Vordächer" alt="" /></a>
									<a href="images/gallery/05.jpg" class="image fit"><img title="Dachrinnen aus Zink, Kupfer, Teracotta" alt="" /></a>									
									<a href="images/gallery/06.jpg" class="image fit"><img title="Auch Industriedächer meistern wir gekonnt, hier der Robinson Club in Portugal" alt="" /></a>
									<a href="images/gallery/07.jpg" class="image fit"><img title="Flachdächer, Balkone und Terrassen haben einen speziellen Abdichtungsanspruch!" alt="" /></a>
									<a href="images/gallery/08.jpg" class="image fit"><img title="Hier zeigen wir Professionalität und Fachwissen, ebenfalls im Robinson Club" alt="" /></a>
									<a href="images/gallery/09.jpg" class="image fit"><img title="Überlassen Sie dies einem Fachmann" alt="" /></a>
									<a href="images/gallery/10.jpg" class="image fit"><img title="Die Nagelprobe zur Überprüfung der Dichtung" alt="" /></a>
									<a href="images/gallery/11.jpg" class="image fit"><img title="Ein Schönes Runddach" alt="" /></a>
									<a href="images/gallery/12.jpg" class="image fit"><img title="Runde Konstruktionen sind besonders Anspruchsvoll" alt="" /></a>
									<a href="images/gallery/13.jpg" class="image fit"><img title="Regenrinnen fertigen wir nach höchsten Masstäben an, damit Wasser richtig abfliesst" alt="" /></a>
									<a href="images/gallery/14.jpg" class="image fit"><img title="Vorbereitungen für ein neues Ziegedach" alt="" /></a>									
								</div>
								<div class="col-sm-6 gallery">
									<header>
										<h3>Zimmerei</h3>
									</header>
									<a id="hover2" href="images/gallery/20.jpg" src="images/gallery/01.jpg" class="image right ">
										<img src="images/thumbs/02.jpg" title="Wir Fertigen auch Individuelle Holz Arbeiten für sie an." alt="" />
										<div id="panel2" class="hover"><p>Holz Zimmerei<br>Maurer-, Putz-, Fliesen<br>und vieles mehr..<br></p></div>
									</a>
									<a href="images/gallery/21.jpg" class="image fit"><img title="Bei Terassen achten wir ebenfalls auf die richtige Abdichtung" alt="" /></a>
									<a href="images/gallery/22.jpg" class="image fit"><img title="Hier der Bau einer Garten Lounge" alt="" /></a>
									<a href="images/gallery/23.jpg" class="image fit"><img title="Selbstverständlich Wetterfest" alt="" /></a>
									<a href="images/gallery/24.jpg" class="image fit"><img title="Auch an einen gemütlichen Kamin haben wir gedacht" alt="" /></a>
									<a href="images/gallery/25.jpg" class="image fit"><img title="Die notwendingen Lüftungen bei Industrie Anlagen beachten wir selbstvertändlich ebenfalls" alt="" /></a>
									<a href="images/gallery/26.jpg" class="image fit"><img title="Der Kreativität sind keine Grenzen gesetzt!" alt="" /></a>
									<a href="images/gallery/27.jpg" class="image fit"><img title="Unterkonstruktionen fertigen wir nach höchsten Masstäben an" alt="" /></a>
									<a href="images/gallery/28.jpg" class="image fit"><img title="Damit Ihr Dach ewig hält" alt="" /></a>
									<a href="images/gallery/29.jpg" class="image fit"><img title="Damit Ihr Dach ewig hält" alt="" /></a>
								</div>
							</div>
						</div>
						<div class="arrow bounce"><a href="#more" class="nav-label"></a></div>
				</div>
				<div id="section2" class="section main style3">
					<header>
						<h2>Eine Korrekte Dachisolierung spart bis zu 40% Heizkosten!</h2>
					</header>
					<div class=" container">
						<div class="col-sm-6">
							<img class="roof" src="images/roof.png" title="Logo" alt="" />
							<p>Eine effiziente Dachisolierung gehört heute förmlich zur Grundausstattung eines Neubaus – 
							bei Altbauten sind nachträgliche Modernisierungen an der Tagesordnung. 
							Umfassende Kenntnisse zum Aufbau der Dachisolierung sind unerlässlich.</p>
							
							<p>Welche Bauweise eine Dachisolierung bezüglich Aufbau und Materialien erfordert,
							entscheidet sich nach den Gegebenheiten des Einzelnen gebäudes und der geeigneten Isoliermetode.
							Ein Neubau stellt andere Anforderungen als ein Altbau.</p>
							
							<p>Durch korrekte Dachisolierung können nicht nur bis zu 40% Heizkosten gespart werden,
							auch Feuchtigkeit und Zugluft werden erfolgreich vom Wohnraum ferngehalten.
							Planen Sie jetzt in enger Abstimmung mit einem Fachmann die verschiedenen Isoliermethoden, 
							wägen Sie deren Vor- und Nachteile ab und überlassen Sie die Bauarbeiten unbedingt einem erfahrenen Profi.</p>
						</div>
						<div class="col-sm-6">
							<p>Bei der Terrassen und Balkonabdichtungen ist es sehr wichtig, auftretendes Wasser effektiv und langfristig abzuführen. 
							Bei den meisten Unterkonstruktionen ist dazu eine zuverlässige Abdichtung unabdingbar. 
							Andernfalls können bei Fliesen- oder Nautsteinbelägen Feuchtigkeitsschäden in Form von Ausblühungen entstehen, 
							was zu Rissen führt und größere Schäden nach sich ziehen kann.</p>
							
							<p>Auch die Nutzungsdauer von Holzbelägen wird maßgeblich davon mitbestimmt, 
							ob Feuchtigkeit ungehindert abtrocknen kann. Wir arbeiten daher mit bituminösen Schweißbahnen oder Flüssigkunststoff,
							um eine Optimale Abdichtung ihrer Terrasse zu gewährleisten.</p>
							
							<p>Um Selbst bei starker Sonne oder leichtem Regen den Freisitz optimal nutzen zu können,
							sind ein guter Sonnenschutz bzw. eine Terrassenüberdachung eine perfekte Ergänzung.</p>
							
							<h4>Vereinbaren Sie jetzt einen Termin für eine Kostenlose Beratung!<h4>
						</div>
							
					</div>
					<div class="arrow bounce"><a href="#contact" class="nav-label"></a></div>
				</div>				
				
				
				<div id="footer" class="section fp-auto-height main style1">				
						<!-- Contact -->
						<div class="content container">
							<header>
								<h3>Wir Freuen uns von Ihnen zu hören</h3>
							</header>
							<footer>
								<h3><img src="assets/css/images/phone.png" class="image phone" />+34 971 64 61 06</h3></img>
								<h3><img src="assets/css/images/phone.png" class="image phone" />+34 671 93 00 62</h3></img>
								<h3><img src="assets/css/images/e_mail.png" class="image letter" /><a href="mailto:dernaechsteregen@hotmail.de"> dernaechsteregen@hotmail.de</a></h3></img>
								<h3><img src="assets/css/images/home.png" class="image home" /> Dachdeckerei Frank Lipp | C. Bonavista 97 | 07230 Montuiri | Mallorca</h3></img>
							</footer>
							<div class="container">
					<!-- Contact Form -->
					  <?php
						// Include the AJAX Contact Form
						include 'assets/mailform/contact-form.php';
					  ?>
							</div>
						</div>
						
				<!-- Menu -->
					<ul class="imp">
						<li><a href="impressum.php" class="">Impressum</a></li>
						<li>&copy; Dachdeckerei Drank Lipp und Söhne</li>
					</ul>
				
				</div>            
</body> 
</html>