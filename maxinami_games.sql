-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 19, 2018 at 11:47 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maxinami_games`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemid` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `pictureLink` varchar(50) NOT NULL,
  `inventory` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:Closed, 1:Board, 2:Video, 3:Card, 4:GiftCard',
  `rating` float NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemid`, `name`, `description`, `price`, `pictureLink`, `inventory`, `type`, `rating`) VALUES
(1, 'Monopoly', 'Choose your token, place it on GO! and roll the dice to own it all! There can be only one winner in the Monopoly game. Will it be you?\r\n\r\nIncludes gameboard, 8 Tokens, 28 Title Deed Cards, 16 Chance Cards, 16 Community Chest Cards, 32 Houses, 12 Hotels, 2 Dice, Money Pack and instructions.\r\n\r\n Fast-dealing property trading game\r\n Players buy, sell and trade properties to win\r\n Build houses and hotels on properties\r\n Change your fortune with Chance and Community Chest cards.\r\n And bankrupt your opponents to win it all\r\n\r\n Ages 8 and up\r\n For 2-8 players\r\n', 14.99, 'monopoly.jpg', 50, 1, 0),
(2, 'Kirby Star Alliance', 'Kirby&trade; is back&mdash;and he\'s finally on the Nintendo Switch console in HD! But this time, he\'s not alone. Recruit enemies by hitting them with hearts and gather helpers for a party of up to four characters. On top of that, you can join with up to three friends for a different kind of team-up action!\r\n\r\nFeatures:\r\n\r\nThe newest Kirby title comes to the Nintendo Switch console in HD\r\nRecruit up to three enemies as helpers by hitting them with hearts\r\nReturning copy abilities include, Sword, Fire, Water, Bomb, Broom and many more!\r\nImbue copy abilities with different elements, such as wind, water, fire and electricity, by borrowing or giving them to helpers to add more attack power, unleash powerful attacks, or solve puzzles\r\nUp to 4 players can join in with the horizontal Joy-Con&trade; controller configuration, or 8 Joy-Con with 4 Joy-Con Grips\r\n', 59.99, 'kirbyStarAlliance.png', 50, 2, 0),
(3, 'Parcheesi', 'Gameboard, 16 plastic pawns (4 sets of 4 colors) 4 individual dice cups, 8 dice (4 sets) and instructions\r\nClassic game of chase, race and capture\r\nAges 8 and up\r\nPlayers: 2 to 4\r\n', 19.99, 'parcheesi.png', 50, 1, 0),
(4, 'Sorry', 'Slide, collide and score to win the game of Sorry! Draw cards to see how far you get to move one of your pawns on the board. If you land on a Slide you can zip to the end and bump your opponents\' pawns &ndash; or your own! Jump over pawns and hide in your Safety zone while getting powers with the 2 power-up tokens. Keep on moving and bumping until you get all three of your pawns from your color Start to your color Home. But watch out, because if you get bumped, Sorry! It\'s all the way back to Start!\r\n\r\nIncludes gameboard, 12 Sorry! Pawns, 44 cards, 2 power-up tokens and instructions\r\n\r\nProduct Features:\r\n&middot; Classic Sorry! game is mystery-solving guessing fun\r\n&middot; Bump other players\' pawns and hide in your Safety Zone, where pawns of other colors can\'t enter\r\n&middot; Power-up tokens give you special powers\r\n\r\nAges 6 and up.\r\nFor 2 to 4 players.\r\n', 9.99, 'sorry.png', 50, 1, 0),
(5, 'Battleship', 'Battleship is the classic naval combat game that brings together competition, strategy, and excitement. In head-to-head battle, you search for the enemy&rsquo;s fleet of ships and destroy them one by one. No ship is safe in this game of stealth and suspense. Try to protect your own fleet while you annihilate your opponent&rsquo;s. It&rsquo;s a battle that you must win!\r\n\r\nYou sank my battleship!\r\n\r\nFeel the authentic thrill of the battle when you wage war on the high seas in the game of Battleship. Take charge and command your own fleet to defeat the enemy. With convenient portable battle cases and realistic naval crafts, Battleship puts you right in the middle of the action. It&rsquo;s a full-out assault. Position your ships strategically to survive the relentless strikes. Then target your opponent&rsquo;s ships and wipe them out. You know you can do it! \r\n\r\nIncludes 2 portable battle cases, 10 plastic ships, 84 red &ldquo;hit&rdquo; pegs, 168 white &ldquo;miss&rdquo; pegs, label sheet, instructions.\r\n\r\nFeatures\r\nIt&rsquo;s head-to-head combat\r\nPlot to sink your opponent&rsquo;s fleet before he sinks yours\r\nThe ultimate search-and-destroy mission\r\nCall your shot and fire\r\nUse the Battleship Salvo feature to launch multiple attacks\r\nTrack down enemy ships on the target grid\r\nPortable battle cases let you play anywhere\r\n\r\nAges 7 and up.\r\n\r\nFor 2 players.\r\n', 7.99, 'battleship.png', 50, 1, 0),
(6, 'Life', 'Spin the wheel of fate and take a drive along the twisting roads families have enjoyed for more than 40 years! Chose a College or Career path and start down the road of life, making money and having babies. You\'ll have adventure after adventure until you reach retirement. If you reach it first, you get a big chunk of change &ndash; and if you\'re the wealthiest player in retirement, you win! \r\nThe Game of Life and all related characters are trademarks of Hasbro.\r\nIncludes gameboard with spinner, cards, Spin to Win tokens, cars, pegs and money pack\r\nFor 2 to 4 players.\r\n', 14.99, 'life.png', 50, 1, 0),
(7, 'Risk', 'Take over the world in this game of strategy conquest, now with updated figures and improved Mission cards. In the Risk game, the goal is simple: players aim to conquer their enemies&rsquo; territories by building an army, moving their troops in, and engaging in battle. Depending on the roll of the dice, a player will either defeat the enemy or be defeated. This exciting game is filled with betrayal, alliances, and surprise attacks. On the battlefield, anything goes! Defeat all of the enemy troops in a territory to conquer that territory and get one step closer to global conquest! The player who completes his or her secret mission first &ndash; and reveals the Secret Mission card to prove it &ndash; wins. And remember&hellip; when it comes to taking over the world, it&rsquo;s all about who is willing to take the biggest Risk.\r\nIncludes gameboard, armies with 40 Infantry, 12 Cavalry, and 8 Artillery each, deck of 56 Risk cards, 1 card box, 5 dice, 5 cardboard war crates, and game guide.\r\nTake over the world in this game of strategy conquest \r\nFeatures updated figures &ndash; includes 300 figures\r\nImproved Mission cards speed up the game; features 12 Secret Missions\r\nRich board art draws players into the Risk gaming world\r\nIncludes 5 war crates for easy storage\r\nAges 10 and up\r\nFor 2 to 5 players.\r\n', 24.99, 'risk.png', 50, 1, 0),
(8, 'Clue', 'One murder&hellip;6 suspects. In this suspenseful Clue game, players have to find out who\'s responsible for murdering Mr. Boddy of Tudor Mansion in his own home. Get the scoop on the mansion\'s rooms, weapons and guests and start detecting! Was it Plum with the wrench in the library? Or Green with the candlestick in the study? Eliminate information throughout the game in this classic whodunit. The player who correctly accuses Who, What, and Where wins!\r\n\r\nIncludes 1 gameboard, 6 tokens, 6 miniature weapons, 30 Cards (6 character cards, 6 weapon cards, 9 room cards, and 9 clue cards, 1 case file envelope, 1 pad of detective notebook sheets, 2 dice, and game guide.\r\n\r\nWho committed the murder in the mansion? \r\nEliminate the suspects and discover whodunit, with what and where\r\nCorrectly guess the murderer to win\r\nIntroducing a new character, Dr. Orchid as one of the suspects\r\nAges 8 years and up\r\nFor 2 to 6 players.\r\n', 7.99, 'clue.png', 50, 1, 0),
(9, 'Chess', 'Folding chess board\r\nFull-sized plastic Staunton Chess figures\r\nIncludes 2.5&quot; King\r\n15&quot; x 15&quot; folding board\r\n32 plastic chess pieces\r\nAges 5 and up\r\n2 Players\r\n', 5.99, 'chess.png', 50, 1, 0),
(10, 'Jenga', 'Want a game experience that combines friends, skill, suspense, laughter, and maybe a little luck? You gotta get the Classic Jenga game! It&rsquo;s the perfect game for everyone, with edge-of-your-seat, gravity-defying action. Do you dive right in and pull your block, or take your time and study the stack? Any way you choose, show your Jenga style!\r\n\r\nHow do you stack up?\r\n\r\nIt&rsquo;s a simple equation. Gather your friends together, throw in a lot of laughter and a little attitude, and get the Classic Jenga party started. Pull the block, stack it on top, and hope the tower doesn&rsquo;t crash down! Classic Jenga is the easy game that you can play anytime, anywhere &ndash; and any way you like. Whether you are serene, scientific, or sneaky when you choose your block, you&rsquo;ll have fun. Be the life of your party with Classic Jenga! \r\n\r\nIncludes 54 Jenga hardwood blocks, stacking sleeve with instructions .\r\n\r\nFeatures:\r\n\r\nKeep the tower from crashing down\r\nIt takes skill, strategy, and luck!\r\nIt&rsquo;s fun, not fussy\r\nChallenge yourself or play with friends\r\nGenuine hardwood blocks\r\nSimple, solid, and timeless\r\n\r\nAges 6 and up. \r\n\r\nFor 1 or more players\r\n', 9.99, 'jenga.png', 50, 1, 0),
(11, 'Scrabble', 'The Scrabble game is a perfect way to spend time with friends and family, whether it\'s a quiet night at home or a party at a friend\'s house. This competitive word game can make any event more interactive, fun and interesting.\r\nGameboard, 100 letter tiles, 4 tile racks, 1 drawstring letter bag, and game guide..\r\nHigh-quality letter tiles and board\r\nPopular word game\r\nClassic family favorite\r\nMany ways to play\r\nChallenging and fun\r\nAges 8 and up\r\nFor 2-4 players\r\n', 9.99, 'scrabble.png', 50, 1, 0),
(12, 'Pokemon Trading Card Game XY Trainer Kit with Pikachu Libre and Suicune', 'The Easy Way to Learn and Play!\r\n\r\nMaster the art of Pok&eacute;mon battling with your favorite Pok&eacute;mon-one card at a time! The Pok&eacute;mon TCG: XY Trainer Kit-Pikachu Libre and Suicune gets you playing from the very first card you draw. And with fun and powerful Pok&eacute;mon at your side, you&rsquo;ll be a Pok&eacute;mon Trainer before you know it!\r\n\r\nThis kit contains everything you need to learn, train, and win! Play both decks against each other, then combine them to create one bigger deck where Pikachu Libre and Suicune battle side by side! Or test your deck at a Pok&eacute;mon League near you and in the Pok&eacute;mon TCG Online!\r\n\r\nTwo 30-card decks each with a specially selected foil card\r\nTwo guided game booklets to teach you how to play-card by card!\r\n2-player playmat with great game tips and rules on the reverse side\r\nDamage counters and Special Condition markers plus a cool Pok&eacute;mon coin!\r\nAn illustrated deck box to keep your new cards in and a code card to play online!\r\nAges 6 and up\r\n', 9.99, 'pokemonTCGpikalibre_suicune.png', 50, 3, 0),
(13, 'Yugioh Yugi Reloaded Starter Deck', 'The original Dueling Legends get their Decks updated in Yugi &mdash; Reloaded and Kaiba &mdash; Reloaded Starter Decks. Each 50-card Deck features that character\'s favorite cards and is tuned to provide easy learning of the Yu-Gi-Oh! trading card game. Fans will love roleplaying and dueling with their hero\'s deck just like on TV! These starter decks were designed to be evenly matched and provide a fun and entertaining jumping-off point for new Duelists. With the ongoing popularity of the original TV series, fans with fond nostalgia have been asking for a modern revamp and their cries have been heard with the Yugi &mdash; Reloaded and Kaiba &mdash; Reloaded Starter Decks. ', 99.99, 'yu-gi-ohTCGstarterYugiReloaded.png', 50, 3, 0),
(14, 'Bang!', 'Fun board game designed for 4-7 players\r\nTakes about 30 minutes to play\r\nFun party game\r\nTons of replay value\r\nIncludes 7 role cards, 16 characters, 80 playing cards, 7 summary cards, 7 player boards, 30 bullet tokens and a rule book\r\nWorld\'s best selling Wild West card game\r\nFun, richer format\r\nEasier to learn and play than ever before\r\n', 19.99, 'bang.png', 50, 3, 0),
(15, 'Bicycle Standard Index Playing Cards', 'A set of 52 playing cards\r\nFun for all ages\r\n', 1.99, 'bicyclePlayingCards.png', 50, 3, 0),
(16, 'Duel Masters Card Game Base Starter Deck', 'DuelMasters Card Game two player starter deck! Enter the &quot;Zone,&quot; a dimensional realm where mythical and mystical battles are fought between wild beings, and journey to become a tournament champion in the Duel Masters TCG! \r\nThis Starter contains two 20-card decks, one booster, an exclusive premium card, a Dreamwave mini-comic, two play mats, a quick start guide, an official rule book, and a DMAX offer. DuelMasters Card Game two player starter deck! Enter the &quot;Zone,&quot; a dimensional realm where mythical and mystical battles are fought between wild beings, and journey to become a tournament champion in the Duel Masters TCG! This Starter contains two 20-card decks, one booster, an exclusive premium card, a Dreamwave mini-comic, two play mats, a quick start guide, an official rule book, and a DMAX offer.\r\n', 14.99, 'duelMastersTCG2playerStarter.png', 50, 3, 0),
(17, 'Magic The Gathering Mirage Starter Deck Mirage', 'Contains 60 cards from the Mirage block.\r\nCard List:\r\nCreature (24)\r\n2 Azimaet Drake\r\n3 Bay Falcon\r\n1 Burning Palm Efreet\r\n1 Dream Fighter\r\n2 Flame Elemental\r\n1 Harmattan Efreet\r\n1 Mist Dragon\r\n3 Pyric Salamander\r\n1 Subterranean Spirit\r\n1 Suq\'Ata Firewalker\r\n2 Talruum Minotaur\r\n3 Teferi\'s Drake\r\n1 Vaporous Djinn\r\n2 Wildfire Emissary\r\n\r\nSorcery (4)\r\n2 Dream Cache\r\n1 Goblin Scouts\r\n1 Kaervek\'s Torch\r\nInstant (8)\r\n2 Boomerang\r\n1 Dissipate\r\n1 Incinerate\r\n2 Meddle\r\n1 Mystical Tutor\r\n1 Power Sink\r\n\r\nLand (24)\r\n12 Island\r\n12 Mountain\r\n', 39.99, 'magic_gatheringMirageStarter.png', 50, 3, 0),
(18, 'Super Mario Odyssey', 'Use amazing new abilities&mdash;like the power to capture and control objects, animals, and enemies&mdash;to collect Power Moons so you can power up the Odyssey airship and save Princess Peach from Bowser\'s wedding plans!\r\n\r\nThanks to heroic, hat-shaped Cappy, Mario\'s got new moves that\'ll make you rethink his traditional run-and-jump gameplay&mdash;like cap jump, cap throw, and capture. Use captured cohorts such as enemies, objects, and animals to progress through the game and uncover loads of hidden collectibles. And if you feel like playing with a friend, just pass them a Joy-Con&trade; controller! Player 1 controls Mario while Player 2 controls Cappy. This sandbox-style 3D Mario adventure&mdash;the first since 1996\'s beloved Super Mario 64&trade; and 2002\'s Nintendo GameCube&trade; classic Super Mario Sunshine&trade;&mdash;is packed with secrets and surprises, plus exciting new kingdoms to explore.\r\n\r\nExplore astonishing new locales like skyscraper-packed New Donk City to your heart\'s content, and run into familiar friends and foes as you try to save Princess Peach from Bowser\'s dastardly wedding plans.\r\nFind something interesting? Toss your cap at it and see what happens! There are lots of fun and surprising ways to interact with your surroundings.\r\nBe sure to bring any coins you find to a Crazy Cap store, where you can exchange them for decorative souvenirs for the Odyssey and new outfits for Mario! Some destinations have very exclusive dress codes, after all&hellip;\r\nHand a Joy-Con&trade; controller to a friend to enjoy simultaneous multiplayer: Player 1 controls Mario while Player 2 controls Mario\'s new ally Cappy.\r\nUse Snapshot Mode to freeze time while playing the game and take screenshots that you can customize using various options and filters. Screenshots can be shared via social media or uploaded to PCs and smart devices* using all of the Nintendo Switch&trade; system\'s built-in screenshot tools.\r\n', 59.99, 'superMarioOdyssey.png', 50, 2, 0),
(19, 'Legend of Zelda: Breath of the Wild', 'Forget everything you know about The Legend of Zelda games. Step into a world of discovery, exploration, and adventure in The Legend of Zelda: Breath of the Wild, a boundary-breaking new game in the acclaimed series. Travel across vast fields, through forests, and to mountain peaks as you discover what has become of the kingdom of Hyrule In this stunning Open-Air Adventure. Now on Nintendo Switch, your journey is freer and more open than ever. Take your system anywhere, and adventure as Link any way you like.\r\n\r\nFeatures:\r\n\r\nExplore the wilds of Hyrule any way you like&mdash;anytime, anywhere! - Climb up towers and mountain peaks in search of new destinations, then set your own path to get there and plunge into the wilderness. Along the way, you\'ll battle towering enemies, hunt wild beasts and gather ingredients for the food and elixirs you\'ll make to sustain you on your journey. With Nintendo Switch, you can literally take your journey anywhere.\r\nMore than 100 Shrines of Trials to discover and explore - Shrines dot the landscape, waiting to be discovered in any order you want. Search for them in various ways, and solve a variety of puzzles inside. The tasks you must perform in each Shrine varies, and you\'ll never expect the challenges you\'ll face until you enter. Some will involve realistic physics, and some will require you to harness the power of nature, including electricity, wind, fire, and more. Work your way through the traps and devices inside, utilizing your runes and think outside the box to earn special items and other rewards that will help you on your adventure.\r\nBe prepared and properly equipped &ndash; With an entire world waiting to be explored, you\'ll need a variety of outfits and gear to reach every corner. You may need to bundle up with warmer clothes or change into something better suited to the desert heat. Some clothing even has special effects that, for example, can make you faster or stealthier.\r\nBattling enemies requires strategy &ndash; The world is inhabited with enemies of all shapes and sizes. Each one has its own attack method and weaponry, so you must think quickly and develop the right strategies to defeat them.\r\namiibo compatibility &ndash; The Wolf Link amiibo from Twilight Princess HD, the Zelda 30th Anniversary series amiibo, and The Legend of Zelda: Breath of the Wild series amiibo are all compatible with this game. Tap the Wolf Link amiibo (sold separately) to make Wolf Link appear in the game. Wolf Link will attack enemies on his own and help you find items you&rsquo;re searching for. Tap a Zelda 30th Anniversary series amiibo to receive helpful in-game items or even a treasure chest!\r\n', 59.99, 'LoZBreathOfTheWild.png', 50, 2, 0),
(20, 'God of War', 'A New Beginning &mdash; His vengeance against the gods of Olympus far behind him, Kratos now lives as a man in the lands of Norse Gods and monsters. It is in this harsh, unforgiving world that he must fight to survive&hellip; and teach his son to do the same\r\nSecond Chances &mdash; As mentor and protector to a son determined to earn his respect, Kratos is faced with an unexpected opportunity to master the rage that has long defined him. Questioning the dark lineage he&rsquo;s passed on to his son, he hopes to make amends for the shortcomings of his past\r\nMidgard and Beyond &mdash; Set within the untamed forests, mountains, and realms of Norse lore, God of War features a distinctly new setting with its own pantheon of creatures, monsters, and gods\r\nVicious, Physical Combat &mdash; With an intimate, over-the-shoulder free camera that brings the action closer than ever, combat in God of War is up close, frenetic, and unflinching. Kratos&rsquo; axe &mdash; powerful, magic and multifaceted &mdash; is a brutal weapon as well as a versatile tool for exploration\r\n', 59.99, 'godOfWar.png', 50, 2, 0),
(21, 'Uncharted: The Lost Legacy', 'Critically-acclaimed developer Naughty Dog\'s standalone Uncharted adventure starring Chloe Frazer.\r\nVenture deep into India\'s Western Ghats as Chloe and Nadine recover an ancient artifact and fight their way through fierce opposition to prevent the region from falling into chaos.\r\nUNCHARTED: The Lost Legacy will come with access to UNCHARTED 4: A Thief\'s End Multiplayer and Survival modes. Online multiplayer on PS4 requires a PlayStation Plus membership, sold separately.\r\n', 29.99, 'unchartedTheLostLegacy.jpg', 50, 2, 0),
(22, 'Shadow of the Colossus', 'Explore vast forbidden lands filled with haunting ruins on a quest to bring a girl back to life\r\nConquer an unforgettable menagerie of towering creatures, each presenting a uniquely crafted challenge to overcome\r\nThe beloved all time classic gets rebuilt from the ground up for PlayStation 4 system;no battery used\r\n', 39.99, 'shadowOfTheColossus.png', 50, 2, 0),
(23, 'Sea of Thieves', 'Sea of Thieves offers the essential pirate experience, packed to the seams with sailing and exploring, fighting and plundering, riddle solving and treasure hunting &ndash; everything you need to live the pirate life you&rsquo;ve always dreamed about. With no set roles, you have complete freedom to approach the world, and other players, however you choose.\r\n\r\n\r\nThe pirate life\r\nA world of real players\r\nIn Sea of Thieves, every sail on the horizon is a crew of real players, but what might their intentions be? Perhaps theyï¿½re seeking peaceful parley, plotting to deprive you of your hard-earned plunder or simply itching to enjoy the thrill of a good battle on the high seas. How you choose to respond may mean the difference between resounding triumph and a close-up look at the ocean floor.\r\n\r\nShared world\r\nShared-World Adventure Game created by Rare Ltd. Be the pirates you want to be in a shared world filled with real players.\r\n\r\n', 59.99, 'seaOfThieves.jpg', 50, 2, 0),
(24, 'Halo 5: Guardians', 'Halo 5: Guardians delivers epic multiplayer experiences that span multiple modes, full-featured level building tools, and a new chapter in the Master Chief saga. And now with Xbox One X, players can experience enhanced visuals, up to 4K resolution, increased visual details, and improved graphic fidelity that makes the game look better than ever before, all while maintaining a consistent 60FPS for the smoothest gameplay possible.\r\n\r\nEPIC CAMPAIGN\r\nThe Master Chief saga continues, with solo and up to 4-player cooperative experience that spans three worlds. A mysterious and unstoppable force threatens the galaxy. The Spartans of Fireteam Osiris and Blue Team must embark on a journey that will change the course of history and the future of mankind.\r\n\r\nWARZONE MULTIPLAYER\r\nPlay with friends and compete against rivals in three massive multiplayer modes new to the Halo franchise: Warzone, Warzone Assault, and Warzone Firefight. \r\n\r\n-WARZONE is a massive-scale multiplayer mode that supports 24-player battles with both friendly and enemy AI constantly dropping in to mix up the experience. \r\n\r\n-In WARZONE ASSAULT, it&rsquo;s 24-player attack-and-defend with the attacking team looking to overrun strategic objectives while the opposing force works to stop the onslaught. \r\n\r\n-WARZONE FIREFIGHT is an ambitious new multiplayer experience that delivers the biggest Halo cooperative experience in franchise history. Up to eight players work together to complete five rounds of increasingly difficult, dynamic objectives set against a timer to emerge victorious.\r\n\r\nARENA MULTIPLAYER\r\nHalo 5&rsquo;s Arena multiplayer continues the established franchise legacy of pure, skill-based 4v4 competitive combat. Multiple Arena modes provide endless ways to play and compete, from classic Slayer and Capture The Flag modes, to popular social modes like Infection, Grifball, and the all-new Super Fiesta.\r\n\r\nFORGE\r\nFor years, Halo&rsquo;s Forge mode has empowered Halo fans to create new maps and game modes that have changed the way people play and experience Halo. Download new levels from the Forge community created on either Windows (using &ldquo;Halo 5: Forge&rdquo; for Windows 10) or Xbox One. Customize existing maps or create your own from scratch. Browse, find, and play an endless array of custom games created and hosted by the community.\r\n\r\nREQ SYSTEM\r\nNew to Halo 5: Guardians is the Requisition System (REQ System), which rewards players for their time spent in Halo 5&rsquo;s multiplayer modes. Players will earn REQ Points after each match in Arena or Warzone which can then be used to purchase REQ Packs containing a variety of REQ items in the form of unlockable weapons, armors, vehicles, stances, assassinations, and more!\r\n', 19.99, 'halo5Guardians.jpg', 50, 2, 0),
(25, 'Gears of War 4', 'A new saga begins for one of the most acclaimed video game franchises in history. After narrowly escaping an attack on their village, JD Fenix and his friends, Kait and Del, must rescue the ones they love and discover the source of a monstrous new enemy. \r\n\r\nNever Fight Alone: Enjoy two-player co-op campaign with friends locally via split-screen or over Xbox Live. Player 2 can select either Kait or Del. Horde 3.0: Team up with four others and battle wave after wave of increasingly difficult enemies by choosing your combat class, leveling up your skills and deploying fortifications anywhere on the map. Explosive Versus Multiplayer: Compete online in new and favorite game types, all at 60fps on dedicated servers. A new visible ranking system means fairer matchmaking for social, competitive and professional players alike.\r\n', 14.99, 'gearsOfWar4.png', 50, 2, 0),
(26, 'Detective Pikachu', 'As Tim Goodman, you\'ll partner with a self-proclaimed &quot;great detective&quot; Pikachu to solve strange occurrences all over Ryme City. Together you must investigate, take notes, and meet up with other Pok&eacute;mon to unravel the city\'s greatest mysteries!\r\n\r\nTim is searching for his missing father in Ryme City, but instead encounters a witty, tough-talking Pikachu! Along the way, experience over 150 fun-filled animated cutscenes starring this unique Pikachu, providing helpful hints or talking up a storm. You can also tap the extra-large Detective Pikachu amiibo&trade; figure to access all cutscenes up until the current chapter played. As you investigate crime scenes, gather testimonies, uncover information, and interact with Pok&eacute;mon to solve cases. You&rsquo;ll have to put your detective skills to the test to foil the mastermind behind the disturbances in Ryme City. All in a day\'s work for detective Pikachu!\r\n\r\nTeam up with self the pro-claimed &quot;great detective&quot; Pikachu!\r\nExperience over 150 animated cutscenes of a fun, and witty talking Pikachu\r\nInvestigate the scene, take notes and crack the case!\r\nInteract with various Pok&eacute;mon throughout Ryme City\r\n', 39.99, 'detectivePikachu.jpg', 50, 2, 0),
(27, 'Nintendo Eshop $50 Gift Card', 'A gift card for the Nintendo Eshop.\r\nThis card is valid for:\r\nNintendo Switch\r\nNintendo 3ds\r\nNintendo 2ds\r\nNintendo Wiiu\r\n', 50, 'nintendoEshop50.png', 50, 4, 0),
(28, 'Steam $50 Gift Card', 'A gift card for Valve Steam.', 50, 'steam50.png', 50, 4, 0),
(29, 'Playstation Store $50 Gift Card', 'A gift card for Playstation Network Store.\r\nThis card is valid for:\r\nPlaystation 3\r\nPlaystation 4\r\nPlaystation Vita\r\nPlaystation Portable System (PSP)\r\n', 50, 'playStationStore50.png', 50, 4, 0),
(30, 'Xbox Live $50 Gift Card', 'A gift card for the Xbox Live store.\r\nThis card is valid for:\r\nXbox One\r\nXbox 360\r\n', 50, 'xbox50.jpg', 50, 4, 0),
(31, 'Mass Effect', 'As Commander Shepard, you lead an elite squad on a heroic, action-packed adventure throughout the galaxy. Discover the imminent danger from an ancient threat and battle the traitorous Saren and his deadly army to save civilization. The fate of all life depends on your actions!\r\nYear: 2007\r\nPlatform: Xbox 360', 19.99, 'massEffect.jpg', 51, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `time_of_purchase` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`user_id`, `product_id`, `quantity`, `time_of_purchase`) VALUES
(4, 20, 2, '2018-04-04 00:00:00'),
(4, 19, 4, '2018-04-07 00:00:00'),
(4, 26, 1, '2018-04-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `address` varchar(70) NOT NULL,
  `hashedpass` varchar(100) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `address`, `hashedpass`, `phonenumber`, `status`) VALUES
(1, 'anonymous', 'anonymous', 'N/A', 'N/A', 'N/A', 2),
(2, 'Admin@maxinami.edu', 'Admin', 'N/A', '$2y$10$mmvPF7UwCXFR7PXkF30O0eKYKDEQ9h6XoZKGMtpYVIkp1cSfg5Iv6', 'N/A', 0),
(4, 'a@gmail.com', 'A A', '1111 1st St Dallas TX 77777', '$2y$10$Tl24GpoOCM5uhafqwxFPAOznFqTmYHCBYeMxse3DA5qVWKTurJhaG', '972-222-2222', 1),
(5, 'mavis@email.com', 'Mavis Francia', '123 Main St', '$2y$10$zkE38n2qBVt5c8Qap.z6YeBCf2jELOkitWcu4i/mPc77RoBMVDYLi', '987-654-3210', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_rating`
--

CREATE TABLE `user_rating` (
  `user_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `description` text,
  `rating` float NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_rating`
--

INSERT INTO `user_rating` (`user_id`, `product_id`, `description`, `rating`) VALUES
(4, 19, 'Great Game', 5),
(4, 20, 'Loved it', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD KEY `item_constraint` (`product_id`),
  ADD KEY `user_constraint` (`user_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_rating`
--
ALTER TABLE `user_rating`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `item_constraint` FOREIGN KEY (`product_id`) REFERENCES `items` (`itemid`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE NO ACTION;

--
-- Constraints for table `user_rating`
--
ALTER TABLE `user_rating`
  ADD CONSTRAINT `user_rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_rating_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `items` (`itemid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
