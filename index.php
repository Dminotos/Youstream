<?php	
session_start(); #starts the session
include_once("libs/common_functions.php"); #includes the session userid variable
include_once("libs/class.User.php"); #connection to User class
include_once("libs/class.Gamer.php"); #connection to Gamer class
include_once("libs/class.Game.php"); #connection to Game class
include_once("libs/class.Home.php"); #connection to Home class
$user = new User; #User class instance
$gamer = new Gamer; #Gamer class instance
$game = new Game; #Game class instance
$home = new Home; #Home class instance
$userid = $_SESSION['userid']; /*Session userid variable*/ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="description" content="Youstreamdb is a site that promotes gaming, unites and expands the ever-growing community of video gaming. Discover cool, funny, engaging streamers & youtubers." />
<title>YouStreamDB - The Gaming Database</title> <?php #The title of the page ?>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"><?php #Browser icon link?>
<link rel="stylesheet" href="css/home.css" type="text/css"> <?php #Home css link ?>
<?php include_once("widgets/cookies.php"); ?>
</head>
<body>
<?php include_once("header.php"); ?>
<?php include_once("widgets/custom_alert_box.php"); ?><?php #topheader instance ?>
<div class="allContainers"> <?php #Main container?>
<?php include_once("widgets/top_adv.php") ?>
<div class="container"><?php /*container of the site*/ ?>
<div class="boxedInfo"><div class="box" ><p id="boxOne"><img src="/images/decorations/FRONT-DISCOVER-new.png" alt="Discover"/></p><p class="boxContent"><span class="box_title">DISCOVER</span> cool, funny, engaging <a id="box_text_link" href="/Gamer/gamers">streamers & youtubers</a> to follow. Pure entertainment, combined with tips & tricks, advise and walkthroughs</p></div>
<div class="box" ><p id="boxTwo"><img src="/images/decorations/FRONT-SHARE-new.png" alt="Share"/></p><p class="boxContent"><span class="box_title" >STAY On TOP</span> of your gaming - find out which <a id="box_text_link" href="/Game/games">game</a> is hot, watch popular gaming videos, get the latest <a id="box_text_link" href="/blog">news</a></p></div>
<div class="box"><p id="boxThree"><img src="/images/decorations/FRONT-CONNECT-new.png" alt="Connect"/></p><p class="boxContent"><span class="box_title">JOIN</span> YoustreamDB. <a id="box_text_link" href="/Login/registration_page">Create your Profile</a>  to follow and vote your favorite youstreamers, talk about games, connect with other gamers and grow your gaming network.</p></div></div>
<div id="game_list_content">
<p id="game_list_title">Top Games</p><ul class="object_list_ul" id="object_game_list"><?php $gamesList = $game->gameEntriesRank(4, 0); /*class.Game.php line 54*/ if($gamesList !== 0){ foreach($gamesList as $gamel){ ?>
<li class="object_list_li" id="game_list_li"><div class="game_object"><div class="flip-container" ontouchstart="this.classList.toggle('hover');"><div class="flipper"><div class="front"><img class="object_list_image" id="games_image" src="/<?php echo htmlspecialchars($gamel['game_logo']); ?>" alt="<?php echo htmlspecialchars($gamel['game_name']); ?>"/></div><div class="back"><div id="game_general_info"><p id="game_genre_title">Genre: </p><p id="game_genre"><?php echo htmlspecialchars($gamel['game_genre']); ?></p><p id="game_platform_title">Platforms: </p><p id="game_platform"><?php echo htmlspecialchars($gamel['game_platform']); ?></p><p id="game_esrb_title"> Esrb Rating: </p><p id="game_esrb"><?php echo htmlspecialchars($gamel['game_age']); ?></p></div><div id="game_site_info"><?php $gameCountGamers = $gamer -> gameCountGamers($gamel['game_id']); if($gameCountGamers !== 0){ foreach($gameCountGamers as $gameCG){?><p id="game_gamers_title"> Youstreamers: </p><p id="game_gamers"><?php echo number_format(htmlspecialchars($gameCG['COUNT(gamer_id)'])); ?></p><?php } }?></div>
<div class="game_actions">
<?php if($loged == 0){ #check if user is not on-line?>
<a href="" id="add_game_offline"><img class="add_game" src="/images/ico-followers12.gif" alt="Add Game"/>Follow</a>
<a href="" id="game_vote_offline_click"><img class="vote_game" src="/images/ico-rated12.gif" alt="Vote Game"/>Vote</a>
<?php }
else if($_SESSION['userid'] != "" && $loged !== 0){
$checkRelation = $game->gameGetUser($userid, $gamel['game_id']); #class.Game.php (line 139)
if($checkRelation == 0){?>
<span id="game_follow_wrap"><a href="" id="add_game_action" gid="<?php echo htmlspecialchars($gamel['game_id']); ?>"><img class="add_game" src="/images/ico-followers12.gif" alt="Add Game"/>Follow</a></span>
<?php }
else{ ?>
<span id="game_unfollow_wrap"><a href="" id="game_unfollow_a" gid="<?php echo htmlspecialchars($gamel['game_id']); ?>"><img class="add_game" src="/images/ico-followers2.png" alt="Add Game"/>Unfollow</a></span>
<?php } 
$uservote = $game->getUserGameVote($userid, $gamel['game_id']);
if($uservote !== 0){
foreach($uservote as $uv){ ?>
<div class="game_vote" id="game_vote" data-average="<?php echo htmlspecialchars($uv['ugv_vote']); ?>" data-id="<?php echo htmlspecialchars($gamel['game_id']); ?>"></div>
<?php } }
else {?>
<div class="game_vote" id="game_vote" data-average="0" data-id="<?php echo htmlspecialchars($gamel['game_id']); ?>"></div>					
<?php } } ?>
</div>
<div id="game_profile"><a href="/Game/singlegame?gamename=<?php echo htmlspecialchars($gamel['game_name']); ?>">Full Profile</a></div>
</div>
</div>
</div>
<a href="Game/singlegame?gamename=<?php echo htmlspecialchars($gamel['game_name']); ?>">
<p id="game_name"><?php echo htmlspecialchars($gamel['game_name']); ?></p>
</a>
<div  class="game_info">
<span id="game_fame" name="<?php echo htmlspecialchars($gamel['game_name']); ?>"><img id="game_fame_image" src="/images/ico-rate.png" alt="fame"/><?php echo htmlspecialchars($gamel['game_averagefame']); ?> / 10</span>
</div>
</div>
</li>
<?php } } ?>
</ul>
<div id="rest_games">
<p id="rest_games_title">More Hot Games</p>
<ul class="object_list_ul" id="object_list_games">
<?php $gamesAll = $game->getAllGames(14, 0); # class.Game.php (line 69)
if($gamesAll !== 0){
foreach($gamesAll as $ga){ ?>
<li class="object_list_li" id="games_list_li">
<div class="games_object">
<?php $game_name = $ga['game_name']; ?>
<a href="/Game/singlegame?gamename=<?php echo htmlspecialchars($game_name); ?>">
<img class="object_list_image" id="other_gamer_avatar" src="<?php echo htmlspecialchars($ga['game_logo']); ?>" alt="<?php echo htmlspecialchars($game_name); ?>" style="width: 49px; height: 49px;"/>
</a>
<p id="user_game_name"><?php echo htmlspecialchars($game_name); ?></p>
</div>
</li>
<?php } } ?>
<li class="object_list_li" id="see_all">
<a href="/Game/games" id="all_youstreamers_a"><img id="see_all_image" src="/images/utility/icons/Button_see_all.png" alt="See All"/></a>
<p id="see_all_image_name">See All</p>
</li>
</ul>
</div>

</div>
<div id="youdb_stats"><p id="youdb_stats_text">35 hot <a id="youdb_stats_games" href="/Game/games">games</a>, over 2500 cool <a id="youdb_stats_youstreamers" href="/Gamer/gamers">Youstreamers</a> already included </br> and we are still growing</p></div>
<div id="top_youstreamers">
<p id="top_title">Top YouTubers & Streamers (Youstreamers)</p>
<?php $topGamer = $gamer->top5GamersList(5);
if($topGamer !== 0){
foreach($topGamer as $tg){ 
$gamer_name_twitch = htmlspecialchars($tg['gamer_username_twitch']);
$gamer_name_youtube = htmlspecialchars($tg['gamer_username_youtube']); ?>
<div id="top_youstreamer">
<div class="top_flip-container" ontouchstart="this.classList.toggle('hover');">
<div class="top_flipper">
<div class="top_front">
<?php if($gamer_name_twitch !== "" && $gamer_name_youtube == ""){ ?>
<div id="top_gamer_logo">
<img class="object_list_image" id="top_gamer_avatar" src="<?php echo htmlspecialchars($tg['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_twitch); ?>"/>
</div>
<?php }
if($gamer_name_youtube !== "" && $gamer_name_twitch == ""){ ?>
<div id="top_gamer_logo">
<img class="object_list_image" id="top_gamer_avatar" src="<?php echo htmlspecialchars($tg['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_youtube); ?>"/>
</div>
<?php }
if($gamer_name_twitch !== "" && $gamer_name_youtube !== ""){?>
<div id="top_gamer_logo">
<img class="object_list_image" id="top_gamer_avatar" src="<?php echo htmlspecialchars($tg['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_twitch); ?>"/>
</div>
<?php } ?>
</div>
<div class="top_back">
<div id="top_game_list">
<ul class="object_list_ul" id="top_object_list_game">
<?php $gamerGames = $gamer->getGamerGames($tg['gamer_id'], 8); # class.Gamer.php (line 69)
if($gamerGames !== 0){
foreach($gamerGames as $gamerG){
$gamesinfo = $game->selectGameInfo($gamerG['game_id']); # class.Gamer.php (line 82)
if($gamesinfo !== 0){
foreach($gamesinfo as $gamel){ ?>
<li class="object_list_li" id="top_game_list_li">
<div class="top_game_object">
<a href="/Game/singlegame.php?gamename=<?php echo htmlspecialchars($gamel['game_name']); ?>">
<img class="object_list_image" id="top_game_icon" src="/<?php echo htmlspecialchars($gamel['game_icon']); ?>" alt="<?php echo htmlspecialchars($gamel['game_name']); ?>" style="width: 30px; height: 30px;"/>
<p id="top_game_name"><?php echo htmlspecialchars($gamel['game_name']); ?></p>
</a>
</div>
</li>
<?php } } } } ?>
</ul>
</div>
<div id="top_gamer_other">
<p id="top_gamer_language_title">Language </p>
<p id="top_gamer_language"><?php echo htmlspecialchars($tg['gamer_language']); ?></p>
<p id="top_youstreamer_genre_title">Gender</p>
<p id="top_youstreamer_genre"><?php echo htmlspecialchars($tg['gamer_genre']); ?></p>
</div>
<div id="top_gamer_you">
<?php if($gamer_name_youtube !== ''){?>
<p id="top_you_follows_title"><img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> Follows </p>
<p id="top_you_follows"> <?php echo number_format(htmlspecialchars($tg['gamer_you_follows'])); ?> </p>
<p id="top_you_videos_title"><img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> Videos </p>
<p id="top_you_videos"> <?php echo number_format(htmlspecialchars($tg['gamer_videos_no'])); ?> </p>
<?php }else{ ?>
<p id="top_you_follows_title"><img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> Follows </p>
<p id="top_you_follows"> N/A </p>
<p id="top_you_videos_title"><img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> Videos </p>
<p id="top_you_videos"> N/A </p>
<?php } ?>
</div>
<div id="top_gamer_twitch">
<?php if($gamer_name_twitch !== ''){?>
<p id="top_twitch_follows_title"><img id="top_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> Follows </p>
<p id="top_twitch_follows"> <?php echo number_format(htmlspecialchars($tg['gamer_twi_follows'])); ?> </p>
<?php }else{ ?>
<p id="top_twitch_follows_title"><img id="top_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> Follows </p>
<p id="top_twitch_follows"> N/A </p>
<?php } ?>
</div>
<div id="top_gamer_actions">
<ul class="top_gamer_actions">
<?php if($loged == 0){ #check if user is not on-line?>
<li class="gamer_actions_li" id="top_ggamer_follow_offline"><a href="" id="top_gamer_follow_offline_a"><img src=" ../images/ico-followers12.gif" alt="Follow">Follow</a></li>
<li class="gamer_actions_li" id="top_ggamer_vote_offline"><a href="" id="top_gamer_vote_offline_a"><img src="../images/ico-rated12.gif" alt="Vote">Vote</a></li>
<?php } else if($_SESSION['userid'] != "" && $loged !== 0){
$checkRelation = $gamer->gamerGetUser($userid, $tg['gamer_id']); #class.Game.php (line 139)
if($checkRelation == 0){ ?>
<li class="gamer_actions_li" id="top_ggamer_follow"><a href="" id="top_gamer_follow_a" grid="<?php echo htmlspecialchars($tg['gamer_id']); ?>"><img src="/images/ico-followers12.gif" alt="Follow">Follow</a></li>
<?php }
else{ ?>
<li class="gamer_actions_li" id="top_ggamer_follow"><a href="" id="top_gamer_unfollow_a" grid="<?php echo htmlspecialchars($tg['gamer_id']); ?>"><img src="/images/ico-followers2.png" alt="Following">Unfollow</a></li>
<?php } ?>
<?php $userVote = $gamer->getUserGamerVote($userid, $tg['gamer_id']);
if($userVote !== 0){
foreach($userVote as $uv){ ?>
<li class="gamer_actions_li" id="top_ggamer_vote"><div class="top_gamer_vote" data-average="<?php echo htmlspecialchars($uv['ugrv_vote']); ?>" data-id="<?php echo htmlspecialchars($tg['gamer_id']); ?>"></div></li>
<?php } } 
else{ ?>
<li class="gamer_actions_li" id="top_ggamer_vote"><div class="top_gamer_vote" id="top_gamer_vote" data-average="0" data-id="<?php echo htmlspecialchars($tg['gamer_id']); ?>"></div></li>
<?php } } ?>
</ul>
</div>
<div id="gamer_profile">
<?php if($gamer_name_twitch !== "" && $gamer_name_youtube == ""){ ?>
<a href="Gamer/singlegamer?gamername=<?php echo $gamer_name_twitch; ?>">Full Profile</a>
<?php } if($gamer_name_youtube !== "" && $gamer_name_twitch == ""){ ?>
<a href="Gamer/singlegamer?gamername=<?php echo $gamer_name_youtube; ?>">Full Profile</a>
<?php } if($gamer_name_twitch !== "" && $gamer_name_youtube !== ""){?>
<a href="Gamer/singlegamer?gamername=<?php echo $gamer_name_twitch; ?>">Full Profile</a>
<?php } ?>
</div>
</div>
</div>
</div>
<p id="top_gamer_name">
<?php
if($gamer_name_twitch !== "" && $gamer_name_youtube == ""){ ?>
<a href="/Gamer/singlegamer?gamername=<?php echo $gamer_name_twitch; ?>">
<img id="top_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> <?php echo $gamer_name_twitch; ?>
</a>
<?php }
if($gamer_name_youtube !== "" && $gamer_name_twitch == ""){ ?>
<a href="/Gamer/singlegamer?gamername=<?php echo $gamer_name_youtube; ?>">
<img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> <?php echo $gamer_name_youtube; ?>
</a>
<?php }
if($gamer_name_twitch !== "" && $gamer_name_youtube !== ""){?>
<a href="/Gamer/singlegamer?gamername=<?php echo $gamer_name_twitch; ?>">
<span><img id="top_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> <?php echo $gamer_name_twitch; ?></span> </br>
<span><img id="top_youtube_image" src="/images/youtube.png" alt="videos"/> <?php echo $gamer_name_youtube; ?></span>
</a>
<?php } ?>
</p>
<div id="top_gamer_info">
<?php if($tg['gamer_twitch_embed'] !== ""){
$channel_name = htmlspecialchars($tg['gamer_twitch_embed']);
$jsonURL = file_get_contents("https://api.twitch.tv/kraken/streams/{$channel_name}");
$json = json_decode($jsonURL);
$id = $json->{'stream'}->{'_id'};
if($id !== null){?>
<p id="top_twitch_live">Live</p>
<?php }	else{ ?>
<p id="top_twitch_offline">Offline</p>
<?php } }else{?>
<p id="top_twitch_not">No Channel</p>
<?php } ?>
<p id="top_gamer_score"><img id="top_gamer_fame_image" src="/images/ico-rate.png" alt="fame"/><?php echo number_format(htmlspecialchars($tg['gamer_totalfame'])); ?></p>
</div>
</div>
<?php }}?>
</div>
<div id="rest_youstreamers">
<p id="rest_youstreamers_title">So Many YouTubers & Streamers (Youstreamers) </p>
<ul class="object_list_ul" id="object_list_youstreamers">
<?php $gameGamers = $gamer->getAllGamer(59, 0); # class.Gamer.php (line 69)
if($gameGamers !== 0){
foreach($gameGamers as $gameG){
$gamersList = $gamer->gameGamersInfo($gameG['gamer_id']); # class.Gamer.php (line 82)
if($gamersList !== 0){
foreach($gamersList as $gamerl){ ?>
<li class="object_list_li" id="youstreamer_list_li">
<div class="youstreamer_object">
<?php 
$gamer_name_twitch = $gamerl['gamer_username_twitch'];
$gamer_name_youtube = $gamerl['gamer_username_youtube'];
if($gamer_name_twitch !== "" && $gamer_name_youtube == ""){ ?>
<a href="/Gamer/singlegamer?gamername=<?php echo htmlspecialchars($gamer_name_twitch); ?>">
<img class="object_list_image" id="other_gamer_avatar" src="<?php echo htmlspecialchars($gamerl['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_twitch); ?>" style="width: 49px; height: 49px;"/>
</a>
<?php }
if($gamer_name_youtube !== "" && $gamer_name_twitch == ""){ ?>
<a href="/Gamer/singlegamer?gamername=<?php echo htmlspecialchars($gamer_name_youtube); ?>">
<img class="object_list_image" id="other_gamer_avatar" src="<?php echo htmlspecialchars($gamerl['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_youtube); ?>" style="width: 49px; height: 49px;"/>
</a>
<?php }
if($gamer_name_twitch !== "" && $gamer_name_youtube !== ""){?>
<a href="/Gamer/singlegamer?gamername=<?php echo htmlspecialchars($gamer_name_twitch); ?>">
<img class="object_list_image" id="other_gamer_avatar" src="<?php echo htmlspecialchars($gamerl['gamer_avatar']); ?>" alt="<?php echo htmlspecialchars($gamer_name_twitch); ?>" style="width: 49px; height: 49px;"/>
</a>
<?php } ?>
<p id="user_gamer_name">
<?php
if($gamer_name_twitch !== "" && $gamer_name_youtube == ""){ ?>
<span><img id="gamer_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> <?php echo htmlspecialchars($gamer_name_twitch); ?></span>
<?php }
if($gamer_name_youtube !== "" && $gamer_name_twitch == ""){ ?>
<span><img id="gamer_youtube_image" src="/images/youtube.png" alt="videos"/> <?php echo htmlspecialchars($gamer_name_youtube); ?></span>
<?php }
if($gamer_name_twitch !== "" && $gamer_name_youtube !== ""){?>
<span><img id="gamer_twitch_image" src="/images/twitch-icon.png" alt="gamers"/> <?php echo htmlspecialchars($gamer_name_twitch); ?></span></br>
<span><img id="gamer_youtube_image" src="/images/youtube.png" alt="videos"/> <?php echo htmlspecialchars($gamer_name_youtube); ?></span>
<?php } ?>
</p>
</div>
</li>
<?php } } } } ?>
<li class="object_list_li" id="see_all">
<a href="/Gamer/gamers" id="all_youstreamers_a"><img id="see_all_image" src="/images/utility/icons/Button_see_all.png" alt="See All"/></a>
<p id="see_all_image_name">See All</p>
</li>
</ul>
</div>
</div> <?php #end of container of the site ?>
<div class="sidecontainer"><?php #Side Container?>
<?php include_once("widgets/sidebar.php") ?>
</div> <?php #End of Side Container?>
</div> <?php #End of main container ?>
<?php include("footer.php"); ?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><?php #JQuery CDN (Content Delivery Network) Google ?>
<script src="js/jssor.slider.mini.js"></script><?php #Slider jquery?>
<script>jQuery(document).ready(function ($){var options = {$AutoPlay: true, $AutoPlayInterval: 4000, $BulletNavigatorOptions: {$Class: $JssorBulletNavigator$,$ChanceToShow: 2}} ; var jssor_slider1 = new $JssorSlider$('homeSliderSide', options);});</script>
<script src="js/home.js"></script> <?php #topheader jquery link?>
<script type="text/javascript" src="js/jquery/jRating.jquery.js"></script>
</html>