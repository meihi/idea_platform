-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2021 年 3 月 09 日 11:08
-- サーバのバージョン： 5.7.30
-- PHP のバージョン: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `idea_platform`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `products`
--

INSERT INTO `products` (`id`, `image`, `title`, `text`, `user_id`, `category_id`, `target_id`, `created_at`, `updated`) VALUES
(1, './../post_images/cc43a8343388dc28db3a58f1b4875e29.jpeg', 'はらぺこあおむし　足型', '０歳クラスの壁面です。\r\n足型ではらぺこあおむしを作りました。\r\n\r\n頭や果物は、絵本を拡大コピーしています。', 1, 1, 1, '2021-02-27 21:55:54', NULL),
(2, './../post_images/914d3d4377f69dc17def662ded6486cd.jpeg', '卒園　壁面', '卒園式の壁面です。\r\n風船部分には卒園する子供達の名前が書いてあります。\r\n奥の風船や横にある小さい風船には不織布をかぶせました。', 3, 1, 7, '2021-02-28 00:20:28', NULL),
(3, './../post_images/7c6f5a7a6e74741d531ddedfeee06cf9.jpeg', '秋の食べ物', 'ピコロ９月号より\r\n和柄の折り紙', 1, 2, 6, '2021-02-28 04:01:32', '2021-03-03 13:38:30'),
(4, './../post_images/f90b506bdabe3ec94cecf8ba8894496f.jpeg', 'a', 'a', 2, 1, 7, '2021-03-01 19:58:33', NULL),
(5, './../post_images/aaeef1f23ee53692510910e4b91aa16c.jpeg', 'ぶどう狩り', '秋の壁面\r\nピコロ９月号より', 2, 1, 7, '2021-03-01 20:01:18', NULL),
(6, './../post_images/40aaa6670fe13f87480cec74d9211845.jpeg', '桜　貼り絵', '保育士があらかじめ切っておいた桜の木と花びらを、子供達に自由に貼り付けてもらいました。\r\nのりの練習にもなります(^ ^)', 1, 2, 3, '2021-03-03 16:51:53', NULL),
(7, './../post_images/5521d20d72b7dc17bca884c05e179b4d.jpeg', '色紙　退園　お別れ　卒園', '退園する園児への寄せ書きやメッセージ色紙です。\r\n卒園児へのプレゼントにも。', 4, 8, 7, '2021-03-03 17:07:05', NULL),
(8, './../post_images/e64d07a19e23854bebcc1aabba4257e4.jpeg', 'ひなまつり　製作　', '着物はコーヒーフィルターに色水を吸わせて作りました。', 4, 2, 6, '2021-03-03 17:11:37', NULL),
(9, './../post_images/21f521bb7dec738012a57c3b29f548f8.jpeg', '手形　トナカイ', '手形をツノに見立てました。\r\n顔を描いたりシールを貼ったりは年齢によって保育士がやってもいいので小さいクラスでもやれそうです！', 1, 2, 2, '2021-03-05 23:01:06', NULL),
(10, './../post_images/99d9a7fa7910b2961f1809e218faea64.jpeg', '退園　色紙', '退園する園児に保育士からの寄せ書きをプレゼントしました。\r\nルルロロが風船を持っているデザインです。\r\n卒園児へのプレゼントなどにも使えそうです！', 5, 8, 7, '2021-03-08 17:26:17', NULL),
(12, './../post_images/f8a0089416b25b207a762bceb688a27a.jpeg', 'たんぽぽ　春　壁面', 'たんぽぽの壁面', 8, 1, 7, '2021-03-09 11:07:22', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
