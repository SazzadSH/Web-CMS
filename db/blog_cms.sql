-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 07, 2019 at 04:45 PM
-- Server version: 5.7.21
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
-- Database: `blog_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(5, 'History'),
(3, 'International'),
(4, 'Politics'),
(1, 'Science'),
(2, 'Sports'),
(6, 'testCat');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `comment_date` date NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `comment` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_approved` tinyint(4) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `fk_comments_post_id_posts_post_id` (`post_id`),
  KEY `fk_comments_comment_id_comments_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `parent_id`, `comment_date`, `name`, `email`, `comment`, `is_active`, `is_approved`) VALUES
(4, 1, NULL, '2018-09-02', 'Test Name', 'test@mail.com', 'sas asas !', 0, 1),
(6, 1, NULL, '2018-09-02', 'Test Name', 'test@test.com', 'Test Comment.', 1, 1),
(7, 17, NULL, '2018-09-03', 'Sazzad Hossen', 'thesazzadsh@gmail.com', 'abc', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(150) NOT NULL,
  `page_body` text,
  `contact` tinyint(4) NOT NULL,
  `comment` tinyint(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_title`, `page_body`, `contact`, `comment`, `is_active`) VALUES
(1, 'About', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel aliquet orci. Donec in augue dui. Ut massa eros, egestas varius ipsum sit amet, mollis suscipit lorem. Integer malesuada placerat maximus. Sed fermentum pretium lectus id facilisis. In hac habitasse platea dictumst. Quisque viverra nibh ac ligula porta varius. Morbi mi justo, porta vel dui id, mollis mattis ligula. Ut a tortor a ante ultricies laoreet.\r\n\r\nProin vel suscipit enim. Sed porttitor ipsum sit amet nisi pretium varius. In venenatis fermentum lobortis. Vivamus vehicula lobortis quam', 0, 0, 1),
(2, 'Contact', 't is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 1, 0, 1),
(4, 'aaaa', 'hjfgjkhfkhgkhg', 1, 1, 1),
(5, 'hdhdhghg', 'fhhfdhfhd', 1, 1, 1),
(6, 'uyfujufg', 'fdhgbu ghfgh dfgh ', 1, 1, 1),
(7, 'hdhdhghg', 'fhhfdhfhd', 1, 1, 1),
(8, 'uyfujufg', 'fdhgbu ghfgh dfgh ', 1, 1, 1),
(9, 'asasasasasasasasasasasasasasasasasasasas', '<p>ytttuutrtrurutu yfh thftdfhrth rthytuyti fgh rtuyt ghgfdgytu yu yu&nbsp;</p>\r\n', 1, 0, 0),
(10, 'Hossen', '<p>qwqwq</p>\r\n', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  `person_name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `imagepath` varchar(256) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`person_id`),
  KEY `fk_users_user_id_persons_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`person_id`, `person_name`, `gender`, `date_of_birth`, `imagepath`, `user_id`) VALUES
(1, 'user testone', 'male', '1990-02-12', '', 1),
(5, 'admin', 'male', '1992-02-01', 'upload/vlcsnap-2017-01-18-19h21m24s653.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `user_id` int(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `fk_users_user_id_posts_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `created_date`, `modified_date`, `user_id`, `is_active`) VALUES
(1, 'This is the first updated Post', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel aliquet orci. Donec in augue dui. Ut massa eros, egestas varius ipsum sit amet, mollis suscipit lorem. Integer malesuada placerat maximus. Sed fermentum pretium lectus id facilisis. In hac habitasse platea dictumst. Quisque viverra nibh ac ligula porta varius. Morbi mi justo, porta vel dui id, mollis mattis ligula. Ut a tortor a ante ultricies laoreet. &quot;In facilisis odio facilisis nisi placerat dapibus. Aliquam eu pharetra nisi. Proin sed pulvinar mi. Ut in risus vitae erat rhoncus convallis. Praesent eu egestas lectus. Quisque accumsan neque non neque egestas efficitur. Praesent in venenatis lorem.&quot; Proin vel suscipit enim. Sed porttitor ipsum sit amet nisi pretium varius. In venenatis fermentum lobortis. Vivamus vehicula lobortis quam.</p>\r\n', '2018-07-28 18:33:40', '2018-08-15 08:35:13', 1, 1),
(2, 'Test Number One', '<p>This is a test Post. This Post is a test. .... .... .... ..... This is Test. Lorem ipsum dolor sit amet, habijabi lol xD.</p>\r\n', '2018-07-28 09:36:47', '2018-08-15 08:58:30', 1, 1),
(3, 'This is post number three', 'Since its inception in 1994, AIUB has been at the forefront in Computing by producing technically skilled and competent IT Professionals to meet the needs of the local and international market. The department has experienced significant growth over the last few years, and is now home of 46 full time faculty, with strong groups in theory, systems, graphics, media, programming languages, computational science, security, AI, and robotics.\r\nAs a technology leader with roots in academia, we are promised to equip our students with the right technology so that they can propel themselves into exciting and fulfilling careers. Our goal is to create a knowledge-based society where our graduates can impart into the rapidly changing technological challenges.', '2018-08-03 04:38:16', '2018-08-03 04:38:16', 1, 1),
(4, 'Test Number Four updated', 'This is a test Post.\r\nThis Post is a test.\r\n.... .... .... .....\r\nThis is Test.\r\nLorem ipsum dolor sit amet, habijabi lol xD.', '2018-08-03 06:54:22', '2018-08-03 07:12:42', 3, 1),
(5, 'Test Number One updated', '<p>This is a test Post. This Post is a test. .... .... .... ..... This is Test. Lorem ipsum dolor sit amet, habijabi lol xD.</p>\r\n', '2018-08-03 06:56:03', '2018-08-15 09:01:09', 1, 1),
(6, 'Test Number One updated', 'This is a test Post.\r\nThis Post is a test.\r\n.... .... .... .....\r\nThis is Test.\r\nLorem ipsum dolor sit amet, habijabi lol xD.', '2018-08-03 06:59:45', '2018-08-03 06:59:45', 1, 1),
(7, 'Hello World', 'Hello World\r\nHello WorldHello WorldHello WorldHello WorldHello World\r\n\r\nHello World\r\nHello World', '2018-08-03 07:08:30', '2018-08-03 07:08:30', 3, 1),
(8, 'Hello World Update 2', 'Hello World\r\nHello WorldHello WorldHello WorldHello WorldHello World\r\n\r\nHello World\r\nHello World', '2018-08-03 07:11:05', '2018-08-03 07:11:48', 1, 1),
(9, 'Hello World 123', 'hdfgsa hsakfhsad hfksdh fsbdf jwahtrwu uawert eu tuiawdh fiueuh kfwqr hkrhnf nkjvh  eiv kl evje ie hvkfh vihfvu fg hkeh rh guierg ierhg 9peqrgi erh8irh iup9qwur fdsjf vuksahusah pogapg he9gu98f glkari ur9g ;lfjgu ut 79wuy gpsj g9pyu g79augphulag 08w ra opio gu9wu ru 8ru98 9psd u9sdu 8osu0 u0asf 0ug9w7t 8ot pjr8o u894wu o8rji jiou g987wutop jsfogja-9ru ir t4uo8wjgowagu98gjolgj osir gr gpi g03uw0g0ekg0 e 0wf0wj f0j3g0 i jker jerk gerkjg309jk 0w p3i 0.', '2018-08-08 10:46:31', '2018-08-08 10:46:31', 1, 0),
(10, 'Another Test', '<p>Hello World. This is another Test. Test. Hello Test. Check. New Test. ///// asjd</p>\r\n\r\n<p>Hello International Test.<br />\r\nHello Int&#39;l Category Test.</p>\r\n', '2018-08-08 08:41:22', '2018-08-15 09:55:21', 1, 1),
(11, 'Test Post Category', '<p>Test Test dfhlfjj ladjfl jadsj lkajg safkg lkadjgiw iaij gierw eriogj orjgsf goir jgj rgjer jgoirjg ojg jrfgj ;orjg esg;o djgj jg sjcijglsjgl sdjfg;sdjs;gj lsjglsdj wirjgow gjewrogjogjerogeogj erogj iejgi er rgjerigjirjgri igi gjigjigjfjslksdjlsk djkljflsj lsajdlakj j jjg iiewjie jjsfj ojgijsijidj osj ojgojeoij JQUERY</p>\r\n', '2018-08-09 08:15:19', '2018-08-15 09:57:03', 1, 1),
(12, 'New Editor Test', '<h1>Heading 1</h1>\r\n\r\n<p><strong>Hello world<br />\r\n<em>hello world italic</em></strong></p>\r\n\r\n<p><strong><em><u>hello world underlined</u></em></strong></p>\r\n\r\n<p><strong><em><u><img alt=\"smiley\" src=\"http://localhost/webTech/cms/admin/ckeditor/plugins/smiley/images/regular_smile.png\" style=\"height:23px; width:23px\" title=\"smiley\" /></u></em></strong></p>\r\n\r\n<p>Plain Text<br />\r\n<span style=\"font-family:Courier New,Courier,monospace\">Font COurier</span></p>\r\n\r\n<h1><span style=\"font-family:Courier New,Courier,monospace\"><span style=\"font-size:22px\">Size 22</span></span></h1>\r\n\r\n<p><input checked=\"checked\" name=\"radioButton\" type=\"radio\" value=\"Radio\" />Radio Button</p>\r\n\r\n<p><img alt=\"yes\" src=\"http://localhost/webTech/cms/admin/ckeditor/plugins/smiley/images/thumbs_up.png\" style=\"height:23px; width:23px\" title=\"yes\" /></p>\r\n\r\n<h1><span style=\"font-family:Courier New,Courier,monospace\"><span style=\"font-size:22px\"><input alt=\"Aiub Website\" src=\"http://www.aiub.edu/\" style=\"border-style:solid; border-width:1px\" type=\"image\" /></span></span></h1>\r\n\r\n<h1><strong><em>&aelig; woah</em></strong></h1>\r\n\r\n<p><strong><em>j</em></strong></p>\r\n\r\n<p>s</p>\r\n\r\n<p><img alt=\"\" src=\"blob:http://localhost/b58ff760-5551-431f-96fd-b06ca4f96637\" style=\"width:5496px\" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"blob:http://localhost/bd7217b0-c813-496b-a213-cc2850c32f3d\" style=\"width:1529px\" /></p>\r\n\r\n<p><a href=\"http://www.aiub.edu\">AIUB Website</a></p>\r\n\r\n<p><img alt=\"\" src=\"blob:http://localhost/21ac7d50-fbcc-41f2-ad62-c1e3588532a3\" style=\"width:680px\" /></p>\r\n\r\n<p><a href=\"/webTech/cms1/admin/ckeditor/kcfinder/upload/images/isThisAPigeon.jpg\" target=\"_self\"><img alt=\"\" src=\"/webTech/cms1/admin/ckeditor/kcfinder/upload/images/isThisAPigeon.jpg\" style=\"height:510px; width:680px\" /></a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>New Image Test</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"/webTech/cms1/admin/ckeditor/kcfinder/upload/images/Forwarding%20Letter%20Industry%20Visit.JPG\" style=\"height:320px; width:250px\" /></p>\r\n', '2018-08-10 07:04:20', '2018-08-15 06:14:55', 1, 1),
(13, 'Category Update Insert Test', '<p>ou need to set the selected attribute of the correct option tag:</p>\r\n\r\n<pre>\r\n\r\n&nbsp;</pre>\r\n<option selected=\"selected\" value=\"January\">January</option>\r\n\r\n<p>Your PHP would look something like this:</p>\r\n\r\n<pre>\r\n\r\n&nbsp;</pre>\r\n<option value=\"January\">&gt;January</option>\r\n\r\n<p>I usually find it neater to create an array of values and loop through that to create a dropdown.</p>\r\n\r\n<p><a href=\"https://stackoverflow.com/a/1336376/8895175\" id=\"link-post-1336376\">share</a><a href=\"https://stackoverflow.com/posts/1336376/edit\">edit</a></p>\r\n\r\n<p>answered&nbsp;Aug 26 &#39;09 at 17:36</p>\r\n\r\n<p><a href=\"https://stackoverflow.com/users/24181/greg\"><img alt=\"\" src=\"https://www.gravatar.com/avatar/8438e7bf53378150813b3dfec7f22232?s=32&amp;d=identicon&amp;r=PG\" style=\"height:32px; width:32px\" /></a></p>\r\n\r\n<p><a href=\"https://stackoverflow.com/users/24181/greg\">Greg</a></p>\r\n\r\n<p>246k45332318</p>\r\n<option>tag. Is that true?&nbsp;&ndash;</option>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Erk sorry, didn&#39;t see your mostly identical comment before posting mine. I&#39;ll upvote yours but leave it to the questioner to pick a winner. Btw, does your opening PHP tag have a typo? or is&nbsp;<code><!--?=</code-->&nbsp;valid?&nbsp;&ndash;&nbsp;<a href=\"https://stackoverflow.com/users/115076/james-wheare\">James Wheare</a><a href=\"https://stackoverflow.com/questions/1336353/how-do-i-set-the-selected-item-in-a-drop-down-box#comment1171023_1336376\">Aug 26 &#39;09 at 17:55</a></code></p>\r\n	</li>\r\n	<li>\r\n	<p><code>Yours gets the tick :) Makes more sense to me haha!&nbsp;&ndash;&nbsp;<a href=\"https://stackoverflow.com/users/161266/tarnfeld\">tarnfeld</a>&nbsp;<a href=\"https://stackoverflow.com/questions/1336353/how-do-i-set-the-selected-item-in-a-drop-down-box#comment1171030_1336376\">Aug 26 &#39;09 at 17:57</a></code></p>\r\n	</li>\r\n	<li>\r\n	<p><code>4</code></p>\r\n\r\n	<p><code><!--?= is valid - it does an echo for youÂ â€“</p--> </code></p>\r\n	</li>\r\n	<li>\r\n	<p><code>I had to modify this, had to put an if statement in.. didn&#39;t work otherwise :)&nbsp;&ndash;&nbsp;</code></p>\r\n	</li>\r\n	<li>\r\n	<p><code>1</code></p>\r\n\r\n	<p><code>In MS Expression Web I get a warning that this (php script) is not permitted inside the HTML5 </code></p>\r\n	</li>\r\n</ul>\r\n\r\n<p><code>&nbsp;</code></p>\r\n', '2018-08-15 09:04:03', '2018-08-15 10:20:41', 1, 1),
(14, 'Tags Test', '<p>THis is a Tag Test<br />\r\n&nbsp;</p>\r\n\r\n<p>Characters within strings may be accessed and modified by specifying the zero-based offset of the desired character after the string using square array brackets, as in&nbsp;<code>$str[42]</code>. Think of a string as an array of characters for this purpose. The functions&nbsp;<code>substr()</code>&nbsp;and&nbsp;<code>substr_replace()</code>can be used when you want to extract or replace more than 1 character.</p>\r\n\r\n<p>Note: As of PHP 7.1.0, negative string offsets are also supported. These specify the offset from the end of the string. Formerly, negative offsets emitted&nbsp;<code>E_N</code></p>\r\n', '2018-08-19 05:04:41', '2018-08-19 05:04:41', 1, 1),
(15, 'Tag Test 2', '<p>Hello World<br />\r\n_uejllajf helfal jjfljiwq ejie af ah jrij wji wle i liw j opwjeoj&nbsp; iwje&nbsp; it iwje</p>\r\n\r\n<p>djsfh kjadlkj ijiej jw ijlwj lwj t lwjlj4 lj wijw jlitjlj ljhw j k;kjwsjt wt jij tj</p>\r\n\r\n<p>*** $ ###</p>\r\n', '2018-08-19 06:27:06', '2018-08-19 07:56:34', 1, 0),
(16, 'Post From Admin', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2018-09-03 03:00:52', '2018-09-03 03:00:52', 5, 1),
(17, 'test', '<p><span style=\"color:#c0392b\"><strong>test test2233</strong></span></p>\r\n', '2018-09-03 05:46:20', '2018-09-03 05:46:49', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

DROP TABLE IF EXISTS `post_category`;
CREATE TABLE IF NOT EXISTS `post_category` (
  `post_category_id` int(10) NOT NULL AUTO_INCREMENT,
  `post_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`post_category_id`),
  KEY `fk_category_category_id_post_category_category_id` (`category_id`),
  KEY `fk_posts_post_id_post_category_post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`post_category_id`, `post_id`, `category_id`) VALUES
(1, 1, 1),
(2, 12, 3),
(5, 2, 5),
(6, 5, 5),
(10, 13, 1),
(39, 10, 3),
(42, 11, 5),
(43, 14, 5),
(44, 15, 1),
(45, 16, 2),
(46, 17, 5);

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
  `site_id` int(10) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) NOT NULL,
  `site_create_date` date NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`site_id`, `site_name`, `site_create_date`) VALUES
(1, 'MyBlog.com', '2018-07-20');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) NOT NULL,
  `post_id` int(10) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`),
  KEY `fk_tags_post_id_post_post_id` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `post_id`) VALUES
(1, 'Lorem', 1),
(2, 'tags', 14),
(3, 'characters', 14),
(4, 'strings', 14),
(5, 'test', 14),
(6, 'tag', 15),
(7, '_underscore', 15),
(8, 'msD_84s', 15),
(9, '_uell', 15),
(10, 'world', 15),
(11, 'hello', 15),
(12, 'ts', 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type_id` int(10) NOT NULL DEFAULT '2',
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_types_type_id_users_user_type_id` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `user_type_id`, `is_active`) VALUES
(1, 'username1', 'user1@email.com', '12345678@', 2, 1),
(3, 'username2', 'user2@email.com', '12345678@', 2, 1),
(5, 'admin', 'admin@test.com', 'admin', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
CREATE TABLE IF NOT EXISTS `user_types` (
  `type_id` int(10) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(15) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`type_id`, `type_name`, `is_active`) VALUES
(1, 'admin', 1),
(2, 'user', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_comment_id_comments_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`comment_id`),
  ADD CONSTRAINT `fk_comments_post_id_posts_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `fk_users_user_id_persons_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_users_user_id_posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `post_category`
--
ALTER TABLE `post_category`
  ADD CONSTRAINT `fk_category_category_id_post_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `fk_posts_post_id_post_category_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `fk_tags_post_id_post_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_types_type_id_users_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
