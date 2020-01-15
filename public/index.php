<?php
require_once '../vendor/autoload.php';
require_once 'EpisodeDataProvider.php';

//Load Twig templating environment
$loader = new Twig_Loader_Filesystem('../templates/');
$twig   = new Twig_Environment($loader, ['debug' => true]);

$data_provider = EpisodeDataProvider::create()->run();
$episode_data  = $data_provider->getEpisodeData();
$error         = $data_provider->getError();
	
//Sort the episodes
$seasons  = array_column($episode_data,"season");
$episodes = array_column($episode_data,"episode");
array_multisort($seasons, SORT_ASC, $episodes, SORT_ASC, $episode_data);	

//Render the template
echo $twig->render('page.html', ["episodes" => $episode_data,"error" => $error]);
