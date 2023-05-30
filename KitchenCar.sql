-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-05-30 17:04:11
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `hew3`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_contact`
--

CREATE TABLE `t_contact` (
  `F_Contact_ID` char(8) NOT NULL,
  `F_ContactName` varchar(50) NOT NULL,
  `F_User_ID` char(8) DEFAULT NULL,
  `F_Mailaddress` varchar(255) NOT NULL,
  `F_ContactCat_ID` char(8) NOT NULL,
  `F_ContactContent` varchar(2000) NOT NULL,
  `F_ContactDateTime` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_contact`
--

INSERT INTO `t_contact` (`F_Contact_ID`, `F_ContactName`, `F_User_ID`, `F_Mailaddress`, `F_ContactCat_ID`, `F_ContactContent`, `F_ContactDateTime`) VALUES
('C101', '予約の件', 'U101', 'syouko@hal.ac.jp', 'T101', '4時に新宿の〇〇で予約した△△ですが、、、、', '2022-12-17 00:23:59'),
('C102', '〇〇店について', 'ゲスト', 'isatishi@hal.ac.jp', 'T102', '○○のメニューについてですが、、、、', '2022-12-17 00:40:51'),
('C103', '店舗ページについて', 'S101', 'tsuru@hal.ac.jp', 'T103', '店のページの○○の表示が、、、', '2022-12-17 00:42:54'),
('C104', '予約の件', 'S101', 'tsuru@hal.ac.jp', 'T101', 'あああああ', '2023-01-27 09:59:03'),
('C105', 'dddd', NULL, 'wawawa@ggg.com', 'T101', 'dddd', '2023-03-02 10:13:39'),
('C106', 'aaa', 'S101', 'aaa@gmail.com', 'T103', 'aaaa', '2023-03-07 04:01:31'),
('C107', 'abc', 'ゲスト', 'a@gmail.com', 'T103', '12345', '2023-03-07 04:06:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_coupon`
--

CREATE TABLE `t_coupon` (
  `F_Coupon_ID` char(8) NOT NULL,
  `F_Coupon_Title` varchar(255) NOT NULL,
  `F_Coupon_Article` varchar(255) DEFAULT NULL,
  `F_Coupon_Value` int(11) NOT NULL,
  `F_Coupon_Code` char(6) NOT NULL,
  `F_Coupon_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_coupon`
--

INSERT INTO `t_coupon` (`F_Coupon_ID`, `F_Coupon_Title`, `F_Coupon_Article`, `F_Coupon_Value`, `F_Coupon_Code`, `F_Coupon_Date`) VALUES
('O101', '全店舗で使える10%オフクーポン発行中！', 'HEW開催を記念して全店舗で使える10%オフクーポンをプレゼント！', 10, 'HALHEW', '2023-03-10'),
('O102', '【3/31日まで】5%OFFクーポン配布中♪', '期間限定で使える5%OFFクーポンを配布しております！', 5, 'TEST01', '2023-03-31');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_couponimages`
--

CREATE TABLE `t_couponimages` (
  `F_Coupon_ID` char(8) NOT NULL,
  `F_CouponImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_couponimages`
--

INSERT INTO `t_couponimages` (`F_Coupon_ID`, `F_CouponImage`) VALUES
('O101', 'Coupon001.png'),
('O102', 'Coupon002.png');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_forum`
--

CREATE TABLE `t_forum` (
  `F_Forum_ID` char(8) NOT NULL,
  `F_Forum_Title` varchar(255) NOT NULL,
  `F_Forum_Article` varchar(2000) DEFAULT NULL,
  `F_ShopName` varchar(255) DEFAULT NULL,
  `F_ForumImage_ID` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_forumimages`
--

CREATE TABLE `t_forumimages` (
  `F_ForumImage_ID` char(8) NOT NULL,
  `F_ForumImage` varchar(255) NOT NULL,
  `F_Forum_ID` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_mailcategory`
--

CREATE TABLE `t_mailcategory` (
  `F_ContactCat_ID` char(8) NOT NULL,
  `F_ContactCatName` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_mailcategory`
--

INSERT INTO `t_mailcategory` (`F_ContactCat_ID`, `F_ContactCatName`) VALUES
('T101', '予約'),
('T102', 'お店'),
('T103', 'サイト');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_product`
--

CREATE TABLE `t_product` (
  `F_Product_ID` char(8) NOT NULL,
  `F_ProductName` varchar(255) NOT NULL,
  `F_ProductImage_ID` char(8) NOT NULL,
  `F_Category_ID` char(8) NOT NULL,
  `F_Shop_ID` char(8) NOT NULL,
  `F_ProductDate` date NOT NULL,
  `F_ProductComment` varchar(2000) DEFAULT NULL,
  `F_Price` int(255) NOT NULL,
  `F_Delete` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_product`
--

INSERT INTO `t_product` (`F_Product_ID`, `F_ProductName`, `F_ProductImage_ID`, `F_Category_ID`, `F_Shop_ID`, `F_ProductDate`, `F_ProductComment`, `F_Price`, `F_Delete`) VALUES
('P101', '特製ビーフコロッケ', 'I141', 'C104', 'S208', '2023-01-04', '国産牛をはじめ厳選素材を使用。', 150, NULL),
('P102', 'ジューシーメンチカツ', 'I142', 'C104', 'S208', '2023-01-04', '肉汁あふれる特製メンチ', 290, NULL),
('P103', 'きのこグラタンコロッケ', 'I143', 'C104', 'S208', '2023-01-04', '大分・湯布院の牛乳使用。', 220, NULL),
('P104', '明太クリーミーコロッケ', 'I144', 'C104', 'S208', '2023-01-04', '福岡県でとれた明太子をたっぷりと使用。', 240, NULL),
('P105', 'しそと塩昆布コロッケ', 'I145', 'C104', 'S208', '2023-01-04', 'しそと昆布の和風コロッケ', 120, NULL),
('P106', '特製トマトコロッケ', 'I146', 'C104', 'S208', '2023-01-05', 'トマト丸ごとチーズ入り！', 340, NULL),
('P107', '特製ザンギコロッケ', 'I147', 'C104', 'S208', '2023-01-05', '北海道産ジャガイモを使用。', 250, NULL),
('P108', 'から揚げもも醤油', 'I148', 'C104', 'S207', '2023-01-05', '特製しょうゆに漬け込み揚げました。当店一番人気！', 550, NULL),
('P109', 'むねだし', 'I149', 'C104', 'S207', '2023-01-05', '特製白だしに漬け込み揚げました。和風テイストです。', 500, NULL),
('P110', 'さがみチキン', 'I150', 'C104', 'S207', '2023-01-05', 'ひと口で食べられるから揚げ。相模原産鶏肉使用。', 350, NULL),
('P111', 'から揚げ棒', 'I151', 'C104', 'S207', '2023-01-05', '選べるソース５種', 400, NULL),
('P112', 'からあげ丼', 'I152', 'C104', 'S207', '2023-01-05', 'もも＆むねを両方頂けます。人気フードメニュー！', 650, NULL),
('P113', '生ビール', 'I153', 'C105', 'S207', '2023-01-05', 'アサヒスーパードライをご用意しております。', 500, NULL),
('P114', 'ソフトドリンク各種', 'I154', 'C105', 'S207', '2023-01-05', '８種のソフトドリンクを提供しております。', 290, NULL),
('P115', 'チョコとバナナ', 'I155', 'C103', 'S206', '2023-01-21', 'チョコとバナナ、クリームの王道の組み合わせ', 550, NULL),
('P116', 'チョコブラウニー', 'I156', 'C103', 'S206', '2023-01-21', 'ほろ苦いブラウニーとチョコソースのチョコ好きにはたまらない一品', 600, NULL),
('P117', 'ダブルベリー', 'I157', 'C103', 'S206', '2023-01-21', '二つのベリーの酸味とクリームの甘さでさっぱりとした味わい', 560, NULL),
('P118', '抹茶あずき', 'I162', 'C103', 'S206', '2023-01-21', '抹茶ソースのほろ苦さが小豆とクリームの甘さを引き立てる和風クレープ', 660, NULL),
('P119', '黒糖ミルク', 'I158', 'C105', 'S206', '2023-01-21', 'オリジナルの黒糖シロップでこっくり甘い味わい', 490, NULL),
('P120', 'キャラメルミルク', 'I159', 'C105', 'S206', '2023-01-21', 'ほろ苦いキャラメルの風味と甘いタピオカのベストマッチ', 490, NULL),
('P121', '抹茶ミルク', 'I160', 'C105', 'S206', '2023-01-21', '抹茶のコクと香りと味わいを楽しめる一品', 550, NULL),
('P122', 'ベリーミルク', 'I161', 'C105', 'S206', '2023-01-21', 'ストロベリーソースの酸味と甘みを楽しむ一品', 550, NULL),
('P123', 'バターチキンカレー', 'I163', 'C104', 'S202', '2023-01-23', 'ヨーグルトやスパイスでじっくり煮込んだカレー', 980, NULL),
('P124', 'キーマカレー', 'I164', 'C104', 'S202', '2023-01-23', 'ゴロゴロひき肉のキーマカレー', 880, NULL),
('P125', '野菜カレー', 'I165', 'C104', 'S202', '2023-01-23', 'たっぷりの野菜が煮込まれた栄養満点カレー', 1080, NULL),
('P126', 'プレーンナン', 'I167', 'C104', 'S202', '2023-01-23', '個おばしく焼き上げたシンプルなナン', 350, NULL),
('P127', 'ガーリックナン', 'I168', 'C104', 'S202', '2023-01-23', 'ガーリックバターを塗って焼き上げたナン', 400, NULL),
('P128', 'チーズナン', 'I169', 'C104', 'S202', '2023-01-23', 'チーズがたっぷり入れて焼き上げたナン', 450, NULL),
('P129', 'マンゴーラッシー', 'I170', 'C105', 'S202', '2023-01-23', 'マンゴーソースたっぷりのフレッシュなラッシー', 500, NULL),
('P130', 'ラッシー', 'I171', 'C105', 'S202', '2023-01-23', 'コクのある甘さのプレーンなラッシー', 450, NULL),
('P131', 'アイスチャイ', 'I172', 'C105', 'S202', '2023-01-23', 'スパイスとミルクティーのカレーにあうチャイ', 450, NULL),
('P132', '本日のカレー', 'I166', 'C104', 'S202', '2023-01-23', '日替わりの店長おすすめカレー', 980, NULL),
('P133', 'ねぎま', 'I173', 'C101', 'S201', '2023-01-24', '炭火の香りとねぎが相性バツグン！', 500, NULL),
('P134', 'レバー', 'I174', 'C101', 'S201', '2023-01-24', '国産肉使用', 500, NULL),
('P135', '鶏もも', 'I175', 'C101', 'S201', '2023-01-24', 'タレがよく合う', 500, NULL),
('P136', 'つくね', 'I176', 'C101', 'S201', '2023-01-24', '大きくておいしい', 400, NULL),
('P137', 'ケバブ', 'I177', 'C103', 'S205', '2023-01-24', 'お店の定番', 700, NULL),
('P138', 'ロールケバブ', 'I178', 'C103', 'S205', '2023-01-24', '食べやすい！', 650, NULL),
('P139', 'フライドポテト', 'I179', 'C103', 'S205', '2023-01-24', '揚げたて', 400, NULL),
('P140', 'トルコアイス', 'I180', 'C103', 'S205', '2023-01-24', 'のびーるトルコアイス', 400, NULL),
('P141', 'カレーパン', 'I119', 'C102', 'S203', '2023-01-24', '玉ねぎと人参を２度炒め、野菜による甘み・うま味が増したカレーを包み揚げた、サックサクのカレーパンです', 150, NULL),
('P142', 'メロンパン', 'I120', 'C102', 'S203', '2023-01-24', '表面はサックリ、中はふんわり。定番のメロンパンです。', 150, NULL),
('P143', 'あんぱん', 'I121', 'C102', 'S203', '2023-01-24', 'さっぱりとした粒あんの甘さに、香ばしい黒ゴマがアクセントの、定番の菓子パン。 ', 120, NULL),
('P144', '塩バターロール', 'I122', 'C102', 'S203', '2023-01-24', '優しい香りのバターを包み、塩をのせ、じゅわっとカリッと焼きあげたこだわりの逸品', 140, NULL),
('P145', 'クロワッサン', 'I123', 'C102', 'S203', '2023-01-24', '発酵バターを使用し、香ばしく焼き上げたクロワッサン。 きめ細かく口当たりも軽く焼き上がっています', 130, NULL),
('P146', '焼きそばパン', 'I124', 'C102', 'S203', '2023-01-24', '店内で調理した焼きそばを使用しています', 180, NULL),
('P147', 'バゲット', 'I125', 'C102', 'S203', '2023-01-24', '外は香ばしく中はしっとり。 長い時間、発酵させることで深みのあるやさしい味に仕上げています。 ', 170, NULL),
('P148', 'クリームパン', 'I126', 'C102', 'S203', '2023-01-24', '濃厚なカスタードクリームがたっぷり詰まった、人気のクリームパンです。', 120, NULL),
('P149', 'たまごサンド', 'I127', 'C102', 'S204', '2023-01-24', '定番かつ人気の商品。\r\n卵本来の味わいが楽しめ、ふわふわな食パンとの相性がバッチリです。 ', 230, NULL),
('P150', 'BLTサンド', 'I128', 'C102', 'S204', '2023-01-24', 'ベーコン・レタス・トマトを使う、BLTサンドイッチ。焼いたベーコンが香ばしくてほどよい塩気があり、レタスとトマトがみずみずしくさっぱりと食べられます ', 240, NULL),
('P151', 'ツナサンド', 'I129', 'C102', 'S204', '2023-01-24', '旨味がぎゅっと凝縮した、基本のツナサンドです。フレッシュなレタスがみずみずしく、相性バッチリ。玉ねぎのシャリッとした食感がアクセントに効いて、クセになるおいしさです ', 230, NULL),
('P152', 'ハムサンド', 'I130', 'C102', 'S204', '2023-01-24', 'シンプルでおいしい、ハムサンドレシピ。食パンにバターとからしマヨネーズを片面ずつ塗ることで、具材のおいしさを引き立てます。', 240, NULL),
('P153', 'カツサンド', 'I131', 'C102', 'S204', '2023-01-24', 'ボリュームがあってつまみやすいカツサンド。ジューシーで食べごたえがあり、しゃきしゃきの千切りキャベツがよく合います ', 270, NULL),
('P154', 'てりやきオムレツサンド', 'I132', 'C102', 'S204', '2023-01-24', 'やきとり缶を使う、照り焼きチキン入りのオムレツサンドです。甘辛たれのやきとりを卵焼きでくるっと巻き、トーストでサンドするレシピ。', 300, NULL),
('P155', 'タンドリーチキンのサンド', 'I133', 'C102', 'S204', '2023-01-24', 'スパイシーでやみつきになる、ボリューミーなタンドリーチキンサンド。食べごたえがあります', 270, NULL),
('P156', 'チキンと卵のサンドイッチ', 'I134', 'C102', 'S204', '2023-01-24', '照り焼きチキンと厚焼き卵、キャロットラペをサンドする、贅沢なひと品。', 280, NULL),
('P157', 'イタリアーナ', 'I107', 'C103', 'S209', '2023-01-24', 'たっぷりのチーズとフレッシュなトマトを贅沢にトッピングしたピザ。', 400, NULL),
('P158', 'もち明太子ピザ', 'I108', 'C103', 'S209', '2023-01-24', '明太子をたっぷり使用したホクホク明太ポテトがのりて相性抜群の和風ピザ。', 300, NULL),
('P159', '大海老のガーリックシュリンプ', 'I109', 'C103', 'S209', '2023-01-24', 'プリプリの大海老を贅沢にトッピングし、オリジナルのガーリックソースで香ばしく仕上げたピザ。', 400, NULL),
('P160', 'ジューシーステーキ', 'I110', 'C103', 'S209', '2023-01-24', 'チーズと相性抜群のバーベキューソースを絡めた、ぴざきゃっと特製ビーフステーキのピザ。', 400, NULL),
('P161', 'チーズ&ハニー', 'I111', 'C103', 'S209', '2023-01-24', '塩味と甘みのバランスが良い人気の一品です。', 300, NULL),
('P162', '贅沢マルゲリータ', 'I112', 'C103', 'S209', '2023-01-24', 'イタリア産ストラッチャテッラチーズのとろける美味しさが味わえる特別なマルゲリータピザ。', 400, NULL),
('P163', 'タルタルチキン南蛮弁当', 'I113', 'C101', 'S210', '2023-01-24', 'カラッと揚がったザクザク食感のチキンに、甘いタレとまろやかなタルタルソースがかかった1品。', 500, NULL),
('P164', '生姜焼き弁当', 'I114', 'C101', 'S210', '2023-01-24', '柔らかい豚肉と玉ねぎを生姜ダレで絡めた、食欲をそそる1品。', 460, NULL),
('P165', '幕の内弁当', 'I115', 'C101', 'S210', '2023-01-24', '様々な種類のおかずが入っており、老若男女を問わず人気のお弁当。', 490, NULL),
('P166', 'とんかつ弁当', 'I116', 'C101', 'S210', '2023-01-24', 'ガッツリ食べたい方におすすめの定番メニュー。', 454, NULL),
('P167', '回鍋肉弁当', 'I117', 'C101', 'S210', '2023-01-24', 'しっかりとした味付けなので、白いご飯との相性も抜群！程よく野菜も摂れる1品。', 490, NULL),
('P168', 'デミハンバーグ弁当', 'I118', 'C101', 'S210', '2023-01-24', '大きめのハンバーグからは肉感がストレートに押し寄せ、食べ応えが抜群のメニュー。', 450, NULL),
('P169', '烏龍ティー', 'I101', 'C105', 'S211', '2023-01-24', '台湾のお茶の定番、烏龍ティー。ほのかに甘く、香ばしい香り、そしてしっかりとしたコクとまろやかな口当たりをお楽しみいただけます。', 420, NULL),
('P170', 'ブラック ミルクティー', 'I102', 'C105', 'S211', '2023-01-24', 'ブラックティー（紅茶）を使用した、1番人気のミルクティーです。飽きのこないすっきりとした味わいで、紅茶の香りとミルクのコクの両方を楽しめます。', 570, NULL),
('P171', 'アールグレイ ミルクティー', 'I103', 'C105', 'S211', '2023-01-24', '「アールグレイティー」をベースにしたミルクティーで、ミルクと合わせてもその華やかな香りは失われることはありません。', 620, NULL),
('P172', '黒糖ミルク 烏龍ティー', 'I104', 'C105', 'S211', '2023-01-24', '芳醇な香りとコクの「烏龍 ミルクティー」に、ゴンチャオリジナルの黒糖シロップを合わせました。', 670, NULL),
('P173', 'ストロベリー阿里山 ティーエード', 'I105', 'C105', 'S211', '2023-01-24', 'フルーティー＆フローラルな甘い香りと深い味わいの「阿里山ウーロンティー」に、果肉が入ったストロベリーソースを合わせました。', 610, NULL),
('P174', 'マンゴー阿里山 フローズンティー', 'I106', 'C105', 'S211', '2023-01-24', '高級台湾茶として名高い、高山茶の一種である阿里山烏龍に、果肉たっぷりのマンゴーソースを合わせ、ひんやりとしたのどごしのフルーティーなフローズンティーに仕立てました。', 570, NULL),
('P175', 'にぎりセット「匠」', 'I135', 'C101', 'S212', '2023-01-24', '10貫のにぎりと軍艦巻のセットです。一番人気！', 1300, NULL),
('P176', '助六', 'I136', 'C101', 'S212', '2023-01-24', 'ふっくらジューシーないなり寿司とかんぴょう巻のセットです。', 650, NULL),
('P177', 'トロづくしセット', 'I137', 'C101', 'S212', '2023-01-24', '中トロとネギトロ各4貫のトロづくしセットです。マグロ好きにはたまらない！', 1500, NULL),
('P178', 'エビづくしセット', 'I138', 'C101', 'S212', '2023-01-24', 'エビ・甘エビ・大甘エビ・炙りエビ各2貫ずつのエビ好きのための一皿。', 1800, NULL),
('P179', 'かっぱ巻', 'I139', 'C101', 'S212', '2023-01-24', 'さっぱりとした酢飯と、しゃきしゃきとしたきゅうりの細巻。', 300, NULL),
('P180', '鉄火巻', 'I140', 'C101', 'S212', '2023-01-24', '細巻きの定番、鉄火巻！わさびとの相性は抜群です。', 500, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_productcategory`
--

CREATE TABLE `t_productcategory` (
  `F_Category_ID` char(8) NOT NULL,
  `F_CategoryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_productcategory`
--

INSERT INTO `t_productcategory` (`F_Category_ID`, `F_CategoryName`) VALUES
('C101', '和食'),
('C102', 'パン・サンドイッチ'),
('C103', '洋食'),
('C104', 'ファストフード'),
('C105', '飲み物');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_productimages`
--

CREATE TABLE `t_productimages` (
  `F_ProductImage_ID` char(8) NOT NULL,
  `F_ProductImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_productimages`
--

INSERT INTO `t_productimages` (`F_ProductImage_ID`, `F_ProductImage`) VALUES
('I101', 'Product001.png'),
('I102', 'Product002.png'),
('I103', 'Product003.png'),
('I104', 'Product004.png'),
('I105', 'Product005.png'),
('I106', 'Product006.png'),
('I107', 'Product007.png'),
('I108', 'Product008.png'),
('I109', 'Product009.png'),
('I110', 'Product010.png'),
('I111', 'Product011.png'),
('I112', 'Product012.png'),
('I113', 'Product013.png'),
('I114', 'Product014.png'),
('I115', 'Product015.png'),
('I116', 'Product016.png'),
('I117', 'Product017.png'),
('I118', 'Product018.png'),
('I119', 'Product019.png'),
('I120', 'Product020.png'),
('I121', 'Product021.png'),
('I122', 'Product022.png'),
('I123', 'Product023.png'),
('I124', 'Product024.png'),
('I125', 'Product025.png'),
('I126', 'Product026.png'),
('I127', 'Product027.png'),
('I128', 'Product028.png'),
('I129', 'Product029.png'),
('I130', 'Product030.png'),
('I131', 'Product031.png'),
('I132', 'Product032.png'),
('I133', 'Product033.png'),
('I134', 'Product034.png'),
('I135', 'Product035.png'),
('I136', 'Product036.png'),
('I137', 'Product037.png'),
('I138', 'Product038.png'),
('I139', 'Product039.png'),
('I140', 'Product040.png'),
('I141', 'Product041.png'),
('I142', 'Product042.png'),
('I143', 'Product043.png'),
('I144', 'Product044.png'),
('I145', 'Product045.png'),
('I146', 'Product046.png'),
('I147', 'Product047.png'),
('I148', 'Product048.png'),
('I149', 'Product049.png'),
('I150', 'Product050.png'),
('I151', 'Product051.png'),
('I152', 'Product052.png'),
('I153', 'Product053.png'),
('I154', 'Product054.png'),
('I155', 'Product055.png'),
('I156', 'Product056.png'),
('I157', 'Product057.png'),
('I158', 'Product058.png'),
('I159', 'Product059.png'),
('I160', 'Product060.png'),
('I161', 'Product061.png'),
('I162', 'Product062.png'),
('I163', 'Product063.png'),
('I164', 'Product064.png'),
('I165', 'Product065.png'),
('I166', 'Product066.png'),
('I167', 'Product067.png'),
('I168', 'Product069.png'),
('I169', 'Product069.png'),
('I170', 'Product070.png'),
('I171', 'Product071.png'),
('I172', 'Product072.png'),
('I173', 'Product073.png'),
('I174', 'Product074.png'),
('I175', 'Product075.png'),
('I176', 'Product076.png'),
('I177', 'Product077.png'),
('I178', 'Product078.png'),
('I179', 'Product079.png'),
('I180', 'Product080.png');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_reserve`
--

CREATE TABLE `t_reserve` (
  `F_Reserve_ID` char(8) NOT NULL,
  `F_Shop_ID` char(8) NOT NULL,
  `F_User_ID` char(8) NOT NULL,
  `F_ReserveDateTime` datetime NOT NULL,
  `F_MeetDateTime` datetime NOT NULL,
  `F_Check` varchar(4) DEFAULT NULL,
  `F_Totalprice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_reserve`
--

INSERT INTO `t_reserve` (`F_Reserve_ID`, `F_Shop_ID`, `F_User_ID`, `F_ReserveDateTime`, `F_MeetDateTime`, `F_Check`, `F_Totalprice`) VALUES
('R101', 'S201', 'S102', '2023-02-16 09:33:00', '2023-02-16 09:33:00', NULL, 0),
('R102', 'S201', 'S102', '2023-02-16 09:33:00', '2023-02-16 09:33:00', NULL, 0),
('R103', 'S203', 'U101', '2023-02-16 09:38:00', '2023-02-16 09:38:00', NULL, 0),
('R104', 'S206', 'U101', '2023-02-17 09:44:00', '2023-02-16 09:44:00', NULL, 0),
('R105', 'S205', 'U101', '2023-02-16 10:35:00', '2023-02-16 10:35:00', NULL, 0),
('R106', 'S208', 'U101', '2023-02-16 11:39:00', '2023-02-16 11:39:00', '1', 0),
('R107', 'S201', 'U102', '2023-02-16 15:09:00', '2023-02-16 15:09:00', NULL, 0),
('R108', 'S208', 'U102', '2023-02-16 15:10:00', '2023-02-16 15:10:00', '1', 0),
('R109', 'S203', 'U101', '2023-02-17 12:02:00', '2023-02-17 12:02:00', NULL, 0),
('R110', 'S202', 'U101', '2023-02-17 12:07:00', '2023-02-17 12:07:00', NULL, 0),
('R111', 'S205', 'U101', '2023-02-17 16:21:00', '2023-02-17 16:21:00', NULL, 0),
('R112', 'S212', 'U101', '2023-03-03 03:25:00', '2023-03-03 03:25:00', NULL, 0),
('R113', 'S203', 'U101', '2023-03-07 02:35:00', '2023-03-07 02:35:00', NULL, 0),
('R114', 'S203', 'U101', '2023-03-07 02:45:00', '2023-03-07 02:45:00', NULL, 0),
('R115', 'S208', 'U101', '2023-03-07 02:52:00', '2023-03-07 02:52:00', '1', 0),
('R116', 'S208', 'U101', '2023-03-07 02:57:00', '2023-03-07 02:57:00', '1', 0),
('R117', 'S211', 'U101', '2023-03-07 03:00:00', '2023-03-07 03:00:00', NULL, 0),
('R118', 'S208', 'U101', '2023-03-07 03:04:00', '2023-03-07 03:04:00', '1', 0),
('R119', 'S208', 'U101', '2023-03-07 03:09:00', '2023-03-07 03:09:00', '1', 0),
('R120', 'S201', 'U101', '2023-03-07 03:18:00', '2023-03-07 03:18:00', NULL, 0),
('R121', 'S208', 'U101', '2023-03-07 03:31:00', '2023-03-07 03:31:00', '1', 0),
('R122', 'S208', 'U101', '2023-03-07 03:35:00', '2023-03-07 03:35:00', '1', 0),
('R123', 'S208', 'U101', '2023-03-07 03:39:00', '2023-03-07 03:39:00', '1', 0),
('R124', 'S208', 'U101', '2023-03-07 03:42:00', '2023-03-07 03:42:00', '1', 0),
('R125', 'S208', 'U101', '2023-03-07 03:45:00', '2023-03-07 03:45:00', '1', 0),
('R126', 'S208', 'U101', '2023-03-07 03:51:00', '2023-03-07 03:51:00', '1', 0),
('R127', 'S208', 'U101', '2023-03-07 03:55:00', '2023-03-07 03:55:00', '1', 0),
('R128', 'S208', 'U101', '2023-03-07 03:58:00', '2023-03-07 03:58:00', '1', 0),
('R129', 'S208', 'U101', '2023-03-07 04:03:00', '2023-03-07 04:03:00', '1', 0),
('R130', 'S205', 'U101', '2023-03-07 04:10:00', '2023-03-07 04:10:00', NULL, 3240),
('R131', 'S208', 'U101', '2023-03-07 04:15:00', '2023-03-07 04:15:00', '1', 783),
('R132', 'S208', 'U101', '2023-03-07 04:29:00', '2023-03-07 04:29:00', '1', 396),
('R133', 'S208', 'U101', '2023-03-07 04:45:00', '2023-03-07 04:45:00', '1', 792),
('R134', 'S208', 'U101', '2023-03-07 04:55:00', '2023-03-07 04:55:00', '1', 261),
('R135', 'S208', 'U101', '2023-03-07 06:10:00', '2023-03-07 06:10:00', '1', 2030),
('R136', 'S208', 'U101', '2023-03-07 06:16:00', '2023-03-07 06:16:00', '1', 522),
('R137', 'S208', 'U101', '2023-03-07 06:20:00', '2023-03-07 06:20:00', '1', 1044),
('R138', 'S208', 'U101', '2023-03-07 06:23:00', '2023-03-07 06:23:00', '1', 216),
('R139', 'S208', 'U101', '2023-03-07 06:30:00', '2023-03-07 06:30:00', '1', 522),
('R140', 'S208', 'U101', '2023-03-07 06:35:00', '2023-03-07 06:35:00', '1', 810),
('R141', 'S208', 'U101', '2023-03-07 06:41:00', '2023-03-07 06:41:00', '1', 1224),
('R142', 'S208', 'U101', '2023-03-07 06:45:00', '2023-03-07 06:45:00', '1', 594),
('R143', 'S208', 'U101', '2023-03-07 06:56:00', '2023-03-07 06:56:00', '1', 783),
('R144', 'S208', 'U101', '2023-03-07 07:04:00', '2023-03-07 07:04:00', '1', 270),
('R145', 'S208', 'U101', '2023-03-07 07:12:00', '2023-03-07 07:12:00', '1', 432),
('R146', 'S204', 'U101', '2023-03-07 07:15:00', '2023-03-07 07:15:00', NULL, 1120),
('R147', 'S208', 'U101', '2023-03-07 07:32:00', '2023-03-07 07:32:00', '1', 612),
('R148', 'S211', 'U101', '2023-03-07 07:36:00', '2023-03-07 07:36:00', NULL, 1140),
('R149', 'S208', 'U101', '2023-03-07 07:50:00', '2023-03-07 07:50:00', '1', 783),
('R150', 'S208', 'U101', '2023-03-07 07:58:00', '2023-03-07 07:58:00', '1', 783),
('R151', 'S208', 'U101', '2023-03-07 08:02:00', '2023-03-07 08:02:00', '1', 810),
('R152', 'S208', 'U101', '2023-03-07 08:23:00', '2023-03-07 08:23:00', NULL, 750);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_reserveproduct`
--

CREATE TABLE `t_reserveproduct` (
  `F_Product_ID` char(4) NOT NULL,
  `F_ProductCount` int(11) NOT NULL,
  `F_Reserve_ID` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_reserveproduct`
--

INSERT INTO `t_reserveproduct` (`F_Product_ID`, `F_ProductCount`, `F_Reserve_ID`) VALUES
('P134', 4, 'R101'),
('P136', 6, 'R101'),
('P134', 4, 'R102'),
('P135', 7, 'R102'),
('P136', 7, 'R102'),
('P142', 4, 'R103'),
('P145', 5, 'R103'),
('P148', 5, 'R103'),
('P116', 1, 'R104'),
('P117', 1, 'R104'),
('P138', 1, 'R105'),
('P139', 1, 'R105'),
('P102', 5, 'R106'),
('P103', 8, 'R106'),
('P135', 1, 'R107'),
('P102', 7, 'R108'),
('P105', 6, 'R108'),
('P103', 7, 'R108'),
('P143', 1, 'R109'),
('P124', 1, 'R110'),
('P151', 1, 'R111'),
('P137', 1, 'R111'),
('P138', 1, 'R111'),
('P178', 9, 'R112'),
('P177', 9, 'R112'),
('P176', 9, 'R112'),
('P175', 9, 'R112'),
('P179', 9, 'R112'),
('P180', 9, 'R112'),
('P146', 1, 'R113'),
('P142', 3, 'R114'),
('P145', 1, 'R114'),
('P102', 4, 'R115'),
('P102', 5, 'R116'),
('P170', 1, 'R117'),
('P102', 4, 'R118'),
('P103', 3, 'R119'),
('P135', 1, 'R120'),
('P104', 1, 'R121'),
('P106', 9, 'R122'),
('P103', 4, 'R123'),
('P101', 4, 'R124'),
('P104', 3, 'R125'),
('P102', 2, 'R126'),
('P107', 1, 'R127'),
('P104', 3, 'R128'),
('P103', 3, 'R129'),
('P139', 9, 'R130'),
('P102', 3, 'R131'),
('P103', 2, 'R132'),
('P103', 4, 'R133'),
('P102', 1, 'R134'),
('P102', 7, 'R135'),
('P102', 2, 'R136'),
('P102', 4, 'R137'),
('P104', 1, 'R138'),
('P102', 2, 'R139'),
('P101', 6, 'R140'),
('P106', 4, 'R141'),
('P103', 3, 'R142'),
('P102', 3, 'R143'),
('P101', 2, 'R144'),
('P104', 2, 'R145'),
('P156', 4, 'R146'),
('P106', 2, 'R147'),
('P170', 2, 'R148'),
('P102', 3, 'R149'),
('P102', 3, 'R150'),
('P101', 6, 'R151'),
('P101', 5, 'R152');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_shop`
--

CREATE TABLE `t_shop` (
  `F_Shop_ID` char(8) NOT NULL,
  `F_ShopName` varchar(255) NOT NULL,
  `F_ShopMailaddress` varchar(255) NOT NULL,
  `F_ShopPhonenumber` varchar(15) NOT NULL,
  `F_ShopPostcode` int(7) NOT NULL,
  `F_ShopAddress` varchar(255) NOT NULL,
  `F_Category_ID` char(8) NOT NULL,
  `F_Forum_ID` char(8) DEFAULT NULL,
  `F_ShopComment` varchar(255) DEFAULT NULL,
  `F_User_ID` varchar(4) NOT NULL,
  `F_Shopimage_ID` varchar(4) NOT NULL,
  `F_OpenTime` time(4) DEFAULT NULL,
  `F_CloseTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_shop`
--

INSERT INTO `t_shop` (`F_Shop_ID`, `F_ShopName`, `F_ShopMailaddress`, `F_ShopPhonenumber`, `F_ShopPostcode`, `F_ShopAddress`, `F_Category_ID`, `F_Forum_ID`, `F_ShopComment`, `F_User_ID`, `F_Shopimage_ID`, `F_OpenTime`, `F_CloseTime`) VALUES
('S201', '串焼き屋', 'odga;ogoi', '07025289978', 9729, '東京都八王子市', 'C101', NULL, ';oiuh;sdfhb@soijbs@[eoijb', 'S103', 'I312', '09:00:00.0000', '18:00:00'),
('S202', 'さちこカレー', 'oviawhejgoaijvosij', '07089447611', 5718, '東京都西多摩郡檜原村', 'C104', NULL, 'voosvovh@o', 'S103', 'I306', '09:00:00.0000', '19:00:00'),
('S203', 'パン屋', 'おりｇｖほえいｇｊ＠お', '07060211796', 29052, '東京都中央区', 'C102', NULL, '；おじぇおｊヴぉじ', 'S103', 'I304', '10:00:00.0000', '19:00:00'),
('S204', 'サンドイッチ', 'おｋｄｆｊｂ；おｚｆｊぼ：', '07060172944', 1271, '東京都葛飾区', 'C102', NULL, '', 'S103', 'I303', '11:00:00.0000', '18:00:00'),
('S205', 'KBB', 'えｄｊべ', '07095777869', 5341, '東京都千代田区', 'C103', NULL, '', 'S103', 'I308', '10:00:00.0000', '19:00:00'),
('S206', '直彦クレープ', 'あえｒｐｇｊ：おあいじおｐ', '07092220149', 27164, '東京都港区', 'C103', NULL, '', 'S103', 'I301', '09:00:00.0000', '18:00:00'),
('S207', '清水からあげ', 'ｚｄヵ：おヴぃｊ', '07058248108', 13323, '東京都調布市', 'C104', NULL, 'いｄｂｈ＠えふぃｂ＠おｆｂｄ', 'S102', 'I310', '09:00:00.0000', '17:00:00'),
('S208', '津留コロッケ', 'あぇｋｊ；おｗｈｆ＠おうぃ', '07059989616', 29167, '東京都中央区', 'C104', NULL, '', 'S101', 'I311', '08:00:00.0000', '19:00:00'),
('S209', 'ぴざきゃっと', 'pizza_meow@gmail.com', '07068716690', 6738, '東京都新宿区歌舞伎町２丁目３７−３', 'C103', NULL, '', 'S103', 'I302', '09:00:00.0000', '20:00:00'),
('S210', 'あっとほーむ弁当', 'athome_bento@yahoo.co.jp', '07060790051', 298213, '東京都新宿区高田馬場４丁目２３', 'C101', NULL, '', 'S103', 'I305', '10:00:00.0000', '21:00:00'),
('S211', 'たぴおかオクノ', 'tapiokaokuno@gmail.com', '07060790051', 5778, '東京都渋谷区神宮前１丁目２０−６', 'C105', NULL, '美味しいタピオカを提供しております！', 'S103', 'I307', '11:00:00.0000', '24:00:00'),
('S212', '寿司処　廣澤', 'hirosawa_sushi@gmail.com', '07099852934', 35806, '東京都港区六本木６丁目１０−１', 'C101', NULL, '六本木ヒルズを中心に寿司を提供しております。\r\n当店一押しのトロずくしセットを是非。', 'S103', 'I309', '12:00:00.0000', '20:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_shopimages`
--

CREATE TABLE `t_shopimages` (
  `F_Shopimage_ID` varchar(4) NOT NULL,
  `F_ShopimageName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_shopimages`
--

INSERT INTO `t_shopimages` (`F_Shopimage_ID`, `F_ShopimageName`) VALUES
('I301', 'Shop001.png'),
('I302', 'Shop002.png'),
('I303', 'Shop003.png'),
('I304', 'Shop004.png'),
('I305', 'Shop005.png'),
('I306', 'Shop006.png'),
('I307', 'Shop007.png'),
('I308', 'Shop008.png'),
('I309', 'Shop009.png'),
('I310', 'Shop010.png'),
('I311', 'Shop011.png'),
('I312', 'Shop012.png');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_userlog`
--

CREATE TABLE `t_userlog` (
  `F_UserLog_ID` char(8) NOT NULL,
  `F_Log_DateTime` varchar(255) NOT NULL,
  `F_Shop_ID` char(8) DEFAULT NULL,
  `F_Reserve_ID` char(8) DEFAULT NULL,
  `F_ShopName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_users`
--

CREATE TABLE `t_users` (
  `F_User_ID` char(8) NOT NULL,
  `F_UserName` varchar(255) NOT NULL,
  `F_LastName` varchar(255) NOT NULL,
  `F_FirstName` varchar(255) NOT NULL,
  `F_UserAddress` varchar(255) NOT NULL,
  `F_UserPostcode` int(7) NOT NULL,
  `F_UserPhonenumber` char(15) NOT NULL,
  `F_BirthdayDate` date NOT NULL,
  `F_UserPass` varchar(255) NOT NULL,
  `F_User_Item` char(8) DEFAULT NULL,
  `F_Coupon_ID` char(8) DEFAULT NULL,
  `F_UserLog_ID` char(8) DEFAULT NULL,
  `F_UserMailaddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `t_users`
--

INSERT INTO `t_users` (`F_User_ID`, `F_UserName`, `F_LastName`, `F_FirstName`, `F_UserAddress`, `F_UserPostcode`, `F_UserPhonenumber`, `F_BirthdayDate`, `F_UserPass`, `F_User_Item`, `F_Coupon_ID`, `F_UserLog_ID`, `F_UserMailaddress`) VALUES
('S101', '', 'つる', 'たかゆき', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2023-01-13', '$2y$10$/BpligfAcOE73gnWjDU2yeyI847lsC5mM2sDJjy560s6o7twOFttG', NULL, NULL, NULL, 'tsuru@hal.ac.jp'),
('S102', '', 'しみず', 'あきひこ', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2022-12-14', '$2y$10$dmvs7c2P5Mo32wKn/4I0N.C35umRCFKCEKjB19xelOCu5yJqwcZXi', NULL, NULL, NULL, 'simizu@hal.ac.jp'),
('S103', '', 'やまぐち', 'なおひこ', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2022-12-01', '$2y$10$5s0Ri8vyE/GtQzn8mpprI.Ko/EFSBtUvT8dKt.0NaK.YN/jD0qvwq', NULL, NULL, NULL, 'yamaguchi@hal.ac.jp'),
('S104', '', 'ばいきん', 'まん', '千葉県習志野市東習志野88888', 2750001, '08099774335', '2023-02-27', '$2y$10$224BxJ1UbeKfphiABoZMoe10OW6ovY97cuIj4TBTqbaN9lLZKFj8i', NULL, NULL, NULL, 'baikinman@hal.ac.jp'),
('U101', '', 'さとう', 'しょうこ', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2022-11-22', '$2y$10$mH.KUtsB/YfUQXdZLBV1WOkGFQ0zgfX6aE0zxjh2/4tURO8OvRZ26', NULL, NULL, NULL, 'syouko@hal.ac.jp'),
('U102', '', 'なかがわ', 'いさとし', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2022-12-04', '$2y$10$VY6yATAUAQuCpZCZMAlE9.7xEs0ngQlZF39cSKimBXtAxCZjg8jNq', NULL, NULL, NULL, 'isatoshi@hal.ac.jp'),
('U103', '', 'むらかみ', 'さちこ', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2023-01-08', '$2y$10$u30Mn5KdphMYBDV/GvbV8OL0CcTHN1QtNskChA8dBtGsN99wPHo1C', NULL, NULL, NULL, 'sachiko@hal.ac.jp'),
('U104', '', 'おくの', 'まさ', '千葉県習志野市東習志野5-18-15', 2750001, '08099774335', '2023-01-08', '$2y$10$9erXbk0O9EO8GcZ0IiTIKOAVO03fnbvBJoM4G7NmqJIsTdUjqMapa', NULL, NULL, NULL, 'okuno@hal.ac.jp');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `t_contact`
--
ALTER TABLE `t_contact`
  ADD PRIMARY KEY (`F_Contact_ID`),
  ADD KEY `F_User_ID` (`F_User_ID`),
  ADD KEY `t_contact_ibfk_1` (`F_ContactCat_ID`);

--
-- テーブルのインデックス `t_coupon`
--
ALTER TABLE `t_coupon`
  ADD PRIMARY KEY (`F_Coupon_ID`);

--
-- テーブルのインデックス `t_couponimages`
--
ALTER TABLE `t_couponimages`
  ADD PRIMARY KEY (`F_Coupon_ID`,`F_CouponImage`);

--
-- テーブルのインデックス `t_forum`
--
ALTER TABLE `t_forum`
  ADD PRIMARY KEY (`F_Forum_ID`),
  ADD KEY `F_ShopName` (`F_ShopName`),
  ADD KEY `F_ForumImage_ID` (`F_ForumImage_ID`);

--
-- テーブルのインデックス `t_forumimages`
--
ALTER TABLE `t_forumimages`
  ADD PRIMARY KEY (`F_ForumImage_ID`),
  ADD KEY `t_forumimege_ibfk_1` (`F_Forum_ID`);

--
-- テーブルのインデックス `t_mailcategory`
--
ALTER TABLE `t_mailcategory`
  ADD PRIMARY KEY (`F_ContactCat_ID`);

--
-- テーブルのインデックス `t_product`
--
ALTER TABLE `t_product`
  ADD PRIMARY KEY (`F_Product_ID`,`F_Shop_ID`),
  ADD KEY `t_product_ibfk_1` (`F_Category_ID`),
  ADD KEY `t_product_ibfk_2` (`F_Shop_ID`),
  ADD KEY `t_product_ibfk_3` (`F_ProductImage_ID`);

--
-- テーブルのインデックス `t_productcategory`
--
ALTER TABLE `t_productcategory`
  ADD PRIMARY KEY (`F_Category_ID`);

--
-- テーブルのインデックス `t_productimages`
--
ALTER TABLE `t_productimages`
  ADD PRIMARY KEY (`F_ProductImage_ID`);

--
-- テーブルのインデックス `t_reserve`
--
ALTER TABLE `t_reserve`
  ADD PRIMARY KEY (`F_Reserve_ID`),
  ADD KEY `F_Shop_ID` (`F_Shop_ID`),
  ADD KEY `F_User_ID` (`F_User_ID`);

--
-- テーブルのインデックス `t_shop`
--
ALTER TABLE `t_shop`
  ADD PRIMARY KEY (`F_Shop_ID`),
  ADD KEY `t_shop_ibfk_1` (`F_ShopName`),
  ADD KEY `t_shop_ibfk_3` (`F_Forum_ID`),
  ADD KEY `t_shop_ibfk_4` (`F_User_ID`),
  ADD KEY `t_shop_ibfk_5` (`F_Category_ID`);

--
-- テーブルのインデックス `t_shopimages`
--
ALTER TABLE `t_shopimages`
  ADD PRIMARY KEY (`F_Shopimage_ID`);

--
-- テーブルのインデックス `t_userlog`
--
ALTER TABLE `t_userlog`
  ADD PRIMARY KEY (`F_UserLog_ID`),
  ADD KEY `F_Shop_ID` (`F_Shop_ID`),
  ADD KEY `F_Reserve_ID` (`F_Reserve_ID`),
  ADD KEY `F_ShopName` (`F_ShopName`);

--
-- テーブルのインデックス `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`F_User_ID`),
  ADD KEY `F_Coupon_ID` (`F_Coupon_ID`,`F_UserLog_ID`),
  ADD KEY `t_users_ibfk_1` (`F_UserLog_ID`);

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `t_contact`
--
ALTER TABLE `t_contact`
  ADD CONSTRAINT `t_contact_ibfk_1` FOREIGN KEY (`F_ContactCat_ID`) REFERENCES `t_mailcategory` (`F_ContactCat_ID`);

--
-- テーブルの制約 `t_forum`
--
ALTER TABLE `t_forum`
  ADD CONSTRAINT `t_forum_ibfk_1` FOREIGN KEY (`F_ShopName`) REFERENCES `t_shop` (`F_ShopName`),
  ADD CONSTRAINT `t_forum_ibfk_2` FOREIGN KEY (`F_ForumImage_ID`) REFERENCES `t_forumimages` (`F_ForumImage_ID`);

--
-- テーブルの制約 `t_forumimages`
--
ALTER TABLE `t_forumimages`
  ADD CONSTRAINT `t_forumimege_ibfk_1` FOREIGN KEY (`F_Forum_ID`) REFERENCES `t_forum` (`F_Forum_ID`);

--
-- テーブルの制約 `t_product`
--
ALTER TABLE `t_product`
  ADD CONSTRAINT `t_product_ibfk_1` FOREIGN KEY (`F_Category_ID`) REFERENCES `t_productcategory` (`F_Category_ID`),
  ADD CONSTRAINT `t_product_ibfk_2` FOREIGN KEY (`F_Shop_ID`) REFERENCES `t_shop` (`F_Shop_ID`),
  ADD CONSTRAINT `t_product_ibfk_3` FOREIGN KEY (`F_ProductImage_ID`) REFERENCES `t_productimages` (`F_ProductImage_ID`);

--
-- テーブルの制約 `t_shop`
--
ALTER TABLE `t_shop`
  ADD CONSTRAINT `t_shop_ibfk_3` FOREIGN KEY (`F_Forum_ID`) REFERENCES `t_forum` (`F_Forum_ID`),
  ADD CONSTRAINT `t_shop_ibfk_4` FOREIGN KEY (`F_User_ID`) REFERENCES `t_users` (`F_User_ID`),
  ADD CONSTRAINT `t_shop_ibfk_5` FOREIGN KEY (`F_Category_ID`) REFERENCES `t_productcategory` (`F_Category_ID`);

--
-- テーブルの制約 `t_userlog`
--
ALTER TABLE `t_userlog`
  ADD CONSTRAINT `t_userlog_ibfk_1` FOREIGN KEY (`F_Shop_ID`) REFERENCES `t_shop` (`F_Shop_ID`),
  ADD CONSTRAINT `t_userlog_ibfk_2` FOREIGN KEY (`F_Reserve_ID`) REFERENCES `t_reserve` (`F_Reserve_ID`),
  ADD CONSTRAINT `t_userlog_ibfk_3` FOREIGN KEY (`F_ShopName`) REFERENCES `t_shop` (`F_ShopName`);

--
-- テーブルの制約 `t_users`
--
ALTER TABLE `t_users`
  ADD CONSTRAINT `t_users_ibfk_1` FOREIGN KEY (`F_UserLog_ID`) REFERENCES `t_userlog` (`F_UserLog_ID`),
  ADD CONSTRAINT `t_users_ibfk_2` FOREIGN KEY (`F_Coupon_ID`) REFERENCES `t_coupon` (`F_Coupon_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
