<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title><?php echo get_site_title(); ?></title>
	<meta name="description" content="<?php echo get_site_description(); ?>">
	<meta name="author" content="Radley Sustaire">
	
	<link rel="preconnect" href="//unpkg.com">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	
	<!-- Open Props: https://open-props.style/#getting-started -->
	<link rel="stylesheet" href="//unpkg.com/open-props"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/normalize.min.css"/>
	<link rel="stylesheet" href="//unpkg.com/open-props/buttons.min.css"/>
	<!-- see PropPacks for the full list -->
	
	<!-- Font: Noto Sans -->
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<style>
		:root {
			--font-family--base: 'Noto Sans', sans-serif;
			--letter-spacing--base: 0.0125em;
		}
	</style>
	<!-- End Font -->
	
	<link href="<?php echo RESUME_URL . '/assets/structure.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/style.css?v=' . get_version(); ?>" rel="stylesheet">
	<link href="<?php echo RESUME_URL . '/assets/print.css?v=' . get_version(); ?>" rel="stylesheet" media="print" id="print-css">
	<link href="<?php echo RESUME_URL . '/assets/font-awesome/all.min.css'; ?>" rel="stylesheet">
	
	<script src="<?php echo RESUME_URL . '/assets/isotope.pkgd.min.js?v=3.0.6'; ?>"></script>
	<script src="<?php echo RESUME_URL . '/assets/main.js?v=' . get_version(); ?>"></script>
	
	<!-- Used in main.js -->
	<style id="hide-if-no-js-style" media="all">.hide-if-no-js { display: none !important; }</style>
	<style id="hide-if-js-style" media="none">.hide-if-js { display: none !important; }</style>
	<!-- End Used in main.js -->
	
	<!-- OG Image -->
	<meta property="og:url" content="<?php echo RESUME_URL; ?>">
	<meta property="og:title" content="<?php echo get_site_title(); ?>">
	<meta property="og:description" content="<?php echo get_site_description(); ?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?php echo RESUME_URL . '/assets/radley-og-image.png'; ?>">
	<!-- End OG Image -->
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-3LR5M0YVTS"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-3LR5M0YVTS');
	</script>
	<!-- End Google tag -->
</head>

<body>