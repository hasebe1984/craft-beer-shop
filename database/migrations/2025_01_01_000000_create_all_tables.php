<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        // データベース作成
        DB::statement('CREATE DATABASE IF NOT EXISTS craftbeer_shop');
        DB::statement('USE craftbeer_shop');

        // 外部キーチェック無効化（削除と作成のため）
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // 既存テーブルの削除（Laravel用テーブル含む）
        DB::statement('DROP TABLE IF EXISTS cache, cache_locks, sessions, order_items, orders, inventory, batches, products, breweries, product_categories, user_addresses, users, reviews, cart_items, payment_methods, posts, post_category, jobs, job_batches, failed_jobs');

        // --- テーブル作成（Laravel標準テーブル） ---
        DB::unprepared("
            create table sessions (
                id varchar(255) primary key,
                user_id int,
                ip_address varchar(45),
                user_agent text,
                payload longtext not null,
                last_activity int not null,
                index(user_id),
                index(last_activity)
            );

            create table cache (
                `key` varchar(255) not null primary key,
                `value` mediumtext not null,
                `expiration` int not null
            );

            create table cache_locks (
                `key` varchar(255) not null primary key,
                `owner` varchar(255) not null,
                `expiration` int not null
            );
        ");

        // --- テーブル作成（アプリ用テーブル） ---
        DB::unprepared("
            -- ユーザーテーブル（Breeze対応: passwordカラムに変更）
            create table users (
                id int primary key auto_increment,
                email varchar(255) unique not null,
                password varchar(255) not null,
                first_name varchar(50) not null ,
                last_name varchar(50) not null,
                remember_token varchar(100),
                created_at datetime,
                updated_at datetime
            ) comment='ユーザー情報を管理';

            create table user_addresses (
                id int primary key auto_increment,
                user_id int,
                postal_code char(7) not null,
                prefecture varchar(20) not null,
                city varchar(50) not null,
                address_line1 varchar(100) not null,
                address_line2 varchar(100) not null,
                is_default Boolean default false,
                foreign key(user_id) references users(id)
            );

            create table product_categories (
                id int primary key auto_increment,
                name varchar(50) unique not null
            );

            create table breweries (
                id int primary key auto_increment,
                name varchar(100) unique not null,
                description text
            );

            create table products (
                id int primary key auto_increment,
                brewery_id int,
                category_id int,
                name varchar(255) not null,
                description text,
                alcohol_by_volume decimal(4,2),
                ibu int,
                price decimal(10, 2) not null,
                image_url varchar(255),
                created_at datetime,
                updated_at datetime,
                foreign key(brewery_id) references breweries(id),
                foreign key(category_id) references product_categories(id)
            );

            create table batches (
                id int primary key auto_increment,
                product_id int,
                batch_code varchar(20),
                brewing_date date,
                expiry_date date,
                stock_quanitity int not null default 0,
                created_at datetime,
                updated_at datetime,
                foreign key (product_id) references products(id)
            );

            create table inventory (
                id int primary key auto_increment,
                product_id int,
                stock_quantity int not null,
                updated_at datetime,
                foreign key (product_id) references products(id)
            );

            create table orders (
                id int primary key auto_increment,
                user_id int,
                status varchar(20) not null,
                total_price decimal(10, 2) not null,
                shipping_address_id int,
                created_at datetime,
                updated_at datetime,
                foreign key (user_id) references users(id),
                foreign key (shipping_address_id) references user_addresses(id)
            );

            create table order_items (
                id int primary key auto_increment,
                order_id int,
                product_id int,
                quantity int not null,
                unit_price decimal(10,2) not null,
                foreign key (order_id) references orders(id),
                foreign key (product_id) references products(id)
            );

            create table reviews (
                id int primary key auto_increment,
                product_id int,
                user_id int,
                rating int not null,
                comment text,
                created_at datetime,
                foreign key (product_id) references products(id),
                foreign key (user_id) references users(id)
            );

            create table cart_items (
                id int primary key auto_increment,
                user_id int,
                product_id int,
                quantity int not null,
                created_at datetime,
                foreign key (user_id) references users(id),
                foreign key (product_id) references products(id)
            );

            create table payment_methods (
                id int primary key auto_increment,
                name varchar(50) not null
            );

            -- ニュース記事用
            create table post_category (
                id int primary key auto_increment,
                name varchar(50),
                slug varchar(50)
            );

            create table posts (
                id int primary key auto_increment,
                category_id int,
                title varchar(255),
                slug varchar(255),
                content longtext,
                excerpt varchar(500),
                image_url varchar(255),
                created_at datetime,
                updated_at datetime,
                published_at datetime,
                foreign key (category_id) references post_category(id)
            );
        ");

        // --- データ挿入 ---

        // 全ユーザー共通のパスワードを作成
        $password = Hash::make('password');

        // 1. ユーザー (パスワードだけPHP変数を使用)
        DB::insert("
            insert into users(email, password, first_name, last_name, created_at,updated_at) values
            ('yamada@example.com', ?, '太郎', '山田', '2025-01-01 10:00:00', '2025-01-01 10:00:00'),
            ('sato@example.com', ?, '花子', '佐藤', '2025-02-15 11:30:00', '2025-02-15 11:30:00'),
            ('tanaka@example.com', ?, '健太', '田中', '2025-03-20 14:00:00', '2025-03-20 14:00:00'),
            ('suzuki@example.com', ?, '美咲', '鈴木', '2025-04-10 16:00:00', '2025-04-10 16:00:00'),
            ('takahashi@example.com', ?, '悟', '高橋', '2025-05-05 09:00:00', '2025-05-05 09:00:00'),
            ('kobayashi@example.com', ?, '由美', '小林', '2025-06-01 13:00:00', '2025-06-01 13:00:00'),
            ('yoshida@example.com', ?, '良太', '吉田', '2025-07-11 15:00:00', '2025-07-11 15:00:00'),
            ('watanabe@example.com', ?, '真理', '渡辺', '2025-08-22 17:00:00', '2025-08-22 17:00:00'),
            ('nakamura@example.com', ?, '雄一', '中村', '2025-09-10 18:00:00', '2025-09-10 18:00:00'),
            ('itou@example.com', ?, '千春', '伊藤', '2025-10-01 19:00:00', '2025-10-01 19:00:00')
        ", [$password, $password, $password, $password, $password, $password, $password, $password, $password, $password]);

        // 2. その他のデータ (提供されたSQLを全て記述)
        DB::unprepared("
            insert into user_addresses(postal_code, prefecture, city, address_line1, address_line2, is_default) values
            ('1000001', '東京都', '千代田区', '千代田1-1-1', '皇居ビル1F', TRUE),
            ('4600001', '愛知県', '名古屋市中区', '栄1-1-1', '栄ビル3F', TRUE),
            ('5300001', '大阪府', '大阪市北区', '梅田1-1-1', '梅田ビル2F', TRUE),
            ('8120011', '福岡県', '福岡市博多区', '博多駅前1-1-1', '博多ビル4F', TRUE),
            ('0600001', '北海道', '札幌市中央区', '北1条西1-1-1', '祇園ビル 12F', TRUE),
            ('9800001', '宮城県', '仙台市青葉区', '中央1-1-1', '仙台ビル5F', TRUE),
            ('7300011', '広島県', '広島市中区', '基町1-1-1', '広島ビル6F', TRUE),
            ('9000001', '沖縄県', '那覇市港町', '港町1-1-1', '那覇ビル 7F', TRUE),
            ('2200001', '神奈川県', '横浜市西区', 'みなとみらい1-1-1', '横浜ビル7F', TRUE),
            ('6000001', '京都府', '京都市下京区', '四条通1-1-1', '京都ビル8F', TRUE);

            insert into product_categories (name) values
            ('Milk Shake IPA'), ('Session IPA'), ('Hazy IPA'), ('Brut IPA'), ('Double IPA'),
            ('Triple IPA'), ('West Coast IPA'), ('Black IPA'), ('Sour IPA'), ('Rye IPA');

            insert into breweries (name, description) values
            ('名古屋ブルワリー', '名古屋市を拠点とする老舗の醸造所です。'),
            ('東京クラフト', '東京の最新トレンドを取り入れたクラフトビールです。'),
            ('大阪ヘイジー', 'フルーティーな香りが特徴的なヘイジーIPA専門の醸造所。'),
            ('京都禅ビア', '和の素材を使った独特の風味を持つクラフトビール。'),
            ('北海道麦酒', '北海道の大自然で育った麦芽を使用したビール。'),
            ('沖縄アイランド', '南国フルーツを使ったトロピカルなビール。'),
            ('博多ビアスタンド', '博多の屋台文化からインスピレーションを受けたビール。'),
            ('横浜ベイサイド', '港町横浜の雰囲気を表現した個性的なビール。'),
            ('広島ピース', '平和の象徴である折り鶴をモチーフにしたビール。'),
            ('仙台杜の都', '杜の都仙台の自然をイメージしたビール。');

            insert into products(brewery_id, category_id, name, description, alcohol_by_volume, ibu, price, image_url, created_at, updated_at) values
            ('2', '3', 'FEAR&TREMBLING', '強いホップの香りと柔らかな口当たりが特徴で、シトラスやトロピカルフルーツの風味が複雑に絡み合う。', '6', '30', '1200', 'img/product/beer04/product-thumbnail04', '2025-01-01 12:00:00', '2025-01-01 14:00:00'),
            ('4', '3', 'EYE CONTACT', '穏やかな苦味とジューシーな果実味が心地よく、日常的に楽しめる一杯。', '5', '21', '900', 'img/product/beer20/product-thumbnail20', '2025-01-02 12:00:00', '2025-01-02 12:00:00'),
            ('6', '1', 'Shake-o-Tron', 'ラクトース（乳糖）を使用することで、まるでミルクセーキのような甘くクリーミーな舌触りを実現したデザートビール。', '3.5', '6', '1100', 'img/product/beer06/product-thumbnail06', '2025-02-10 12:00:00', '2025-02-10 12:00:00'),
            ('8', '10', 'ALIEN EINSTEIN', 'ライ麦由来のスパイシーな風味がホップの苦味と融合し、未知なる味わいの世界へと誘う。', '15', '77', '1800', 'img/product/beer07/product-thumbnail07', '2025-02-15 12:00:00', '2025-02-15 12:00:00'),
            ('10', '5', 'brainrot', '大量のホップとモルトを使い、強烈な苦味と濃厚なフレーバーが脳を揺さぶるようなインパクトを与える。', '7.5', '64', '1000', 'img/product/beer08/product-thumbnail08', '2025-03-01 12:00:00', '2025-03-01 12:00:00'),
            ('3', '6', 'STAMPEDE RUN', '極限までホップを投入し、圧倒的な苦味とパンチの効いたアロマが怒涛のごとく押し寄せる。', '13', '99', '1100', 'img/product/beer09/product-thumbnail09', '2025-04-05 12:00:00', '2025-04-05 12:00:00'),
            ('9', '4', 'FRESCO', 'ドライでキレのある後味がシャンパンのようで、ホップのフルーティーな香りをより一層際立たせた軽やかな仕上がり。', '7', '53', '1500', 'img/product/beer10/product-thumbnail10', '2025-05-10 12:00:00', '2025-05-10 12:00:00'),
            ('1', '7', 'VIVID ENERGY', 'クリアな外観と、グレープフルーツや松を思わせるシャープなホップのアロマ、キレのある苦味が特徴。', '8', '41', '2100', 'img/product/beer11/product-thumbnail11', '2025-06-01 12:00:00', '2025-06-01 12:00:00'),
            ('5', '7', 'SMOKIN ACES', 'スモーキーな香りがホップの風味と絶妙に調和し、西部劇を思わせるワイルドな個性が際立つ。', '11', '100', '800', 'img/product/beer12/product-thumbnail12', '2025-07-10 12:00:00', '2025-07-10 12:00:00'),
            ('6', '9', 'HOP SOLO', '爽快な酸味とホップの香りが織りなすユニークな味わいで、喉を潤すのに最適な一杯。', '2', '7', '1200', 'img/product/beer13/product-thumbnail13', '2025-08-15 12:00:00', '2025-08-15 12:00:00'),
            ('2', '2', 'LIFE IN SPACE', 'アルコール度数を抑えながらも、ホップの香りをしっかりと楽しむことができ、長い時間ゆっくりと味わえる。', '4', '14', '800', 'img/product/beer03/product-thumbnail03', '2025-10-10 12:00:00', '2025-10-10 12:00:00'),
            ('3', '8', 'FLOWER', 'ロースト麦芽の香ばしさと、ホップの華やかな風味が共存する、見た目とは裏腹に飲みやすい一杯。', '7.4', '85', '1100', 'img/product/beer15/product-thumbnail15', '2025-11-10 12:00:00', '2025-11-10 12:00:00'),
            ('5', '3', 'GREEN DAY', '爽やかなハーブの香りとスッキリとした味わいが、晴れた日の草原を思わせるような清々しい一杯。', '3.2', '23', '1000', 'img/product/beer02/product-thumbnail02', '2025-11-11 12:00:00', '2025-11-11 12:00:00'),
            ('7', '3', 'OCTOPUS', '複雑でユニークな風味が特徴で、タコの足のように幾重にも重なる奥深い味わいをゆっくりと楽しめる。様々なフルーツの組み合わせが楽しい一杯。', '6', '73', '1100', 'img/product/beer22/product-thumbnail22', '2025-11-14 12:00:00', '2025-11-14 12:00:00'),
            ('2', '3', 'WORM!', '土から生まれたような、力強い野菜の風味とほのかなハーブの香りが印象的な一杯。', '3.9', '43', '1500', 'img/product/beer21/product-thumbnail21', '2025-11-24 12:00:00', '2025-11-24 12:00:00'),
            ('10', '3', 'BAZOOKA CAT', 'バズーカのような強烈なインパクトを与える刺激的な風味と、猫のように気まぐれで複雑なフレーバーが混ざり合う、元気が出る一杯。', '8', '85', '900', 'img/product/beer17/product-thumbnail17', '2025-12-10 12:00:00', '2025-12-10 12:00:00');

            insert into batches(product_id, batch_code, brewing_date, expiry_date, stock_quanitity, created_at, updated_at) values
            (1, '20250915-01', '2025-09-15', '2026-03-15', 150, '2025-09-20 10:00:00', '2025-10-01 15:00:00'),
            (2, '20250930-01', '2025-09-30', '2026-03-30', 380, '2025-10-05 11:30:00', '2025-10-05 11:30:00'),
            (3, '20251015-01', '2025-10-15', '2026-04-15', 600, '2025-10-20 12:00:00', '2025-10-25 14:00:00'),
            (4, '20251025-01', '2025-10-25', '2026-04-25', 320, '2025-10-30 13:45:00', '2025-10-30 13:45:00'),
            (5, '20251120-01', '2025-11-20', '2026-05-20', 0, '2025-11-25 14:00:00', '2025-12-01 10:00:00'),
            (5, '20260110-01', '2026-01-10', '2026-07-10', 450, '2026-01-15 14:00:00', '2026-01-15 14:00:00'),
            (6, '20251201-01', '2025-12-01', '2026-06-01', 250, '2025-12-05 09:30:00', '2025-12-05 09:30:00'),
            (7, '20260105-01', '2026-01-05', '2026-07-05', 700, '2026-01-10 10:00:00', '2026-01-15 12:00:00'),
            (8, '20260120-01', '2026-01-20', '2026-07-20', 180, '2026-01-25 11:00:00', '2026-01-25 11:00:00'),
            (8, '20260301-01', '2026-03-01', '2026-09-01', 300, '2026-03-05 11:00:00', '2026-03-05 11:00:00'),
            (9, '20260205-01', '2026-02-05', '2026-08-05', 420, '2026-02-10 12:30:00', '2026-02-10 12:30:00'),
            (10, '20260225-01', '2026-02-25', '2026-08-25', 580, '2026-03-01 14:00:00', '2026-03-05 15:00:00'),
            (11, '20260315-01', '2026-03-15', '2026-09-15', 300, '2026-03-20 15:00:00', '2026-03-20 15:00:00'),
            (12, '20260330-01', '2026-03-30', '2026-09-30', 480, '2026-04-05 10:00:00', '2026-04-10 10:00:00'),
            (13, '20260415-01', '2026-04-15', '2026-10-15', 0, '2026-04-20 11:00:00', '2026-04-20 11:00:00'),
            (13, '20260520-01', '2026-05-20', '2026-11-20', 630, '2026-05-25 11:00:00', '2026-05-25 11:00:00'),
            (14, '20260501-01', '2026-05-01', '2026-11-01', 330, '2026-05-05 12:00:00', '2026-05-10 13:00:00'),
            (15, '20260515-01', '2026-05-15', '2026-11-15', 510, '2026-05-20 13:30:00', '2026-05-20 13:30:00'),
            (16, '20260601-01', '2026-06-01', '2026-12-01', 400, '2026-06-05 14:00:00', '2026-06-10 14:00:00');

            insert into orders(user_id, status, total_price, shipping_address_id, created_at, updated_at) values
            (1, 'pending', 4500, 1, '2025-10-10 15:30:00', '2025-10-10 15:30:00'),
            (2, 'processing', 8800, 2, '2025-10-11 09:00:00', '2025-10-11 11:00:00'),
            (3, 'shipped', 12500, 3, '2025-10-12 18:45:00', '2025-10-14 10:00:00'),
            (4, 'delivered', 3200, 4, '2025-10-13 10:20:00', '2025-10-15 14:30:00'),
            (5, 'canceled', 6700, 5, '2025-10-14 07:00:00', '2025-10-14 07:05:00'),
            (1, 'shipped', 7100, 1, '2025-10-14 20:10:00', '2025-10-16 09:00:00'),
            (6, 'processing', 5000, 6, '2025-10-15 11:40:00', '2025-10-16 12:00:00'),
            (7, 'pending', 9200, 7, '2025-10-16 16:00:00', '2025-10-16 16:00:00'),
            (8, 'delivered', 10500, 8, '2025-10-17 08:30:00', '2025-10-17 10:00:00'),
            (3, 'processing', 4800, 3, '2025-10-17 12:00:00', '2025-10-17 12:00:00'),
            (10, 'delivered', 7500, 10, '2025-10-18 09:00:00', '2025-10-20 10:00:00'),
            (1, 'delivered', 14200, 1, '2025-10-18 15:00:00', '2025-10-20 11:30:00'),
            (3, 'pending', 6000, 3, '2025-10-19 10:30:00', '2025-10-19 10:30:00'),
            (8, 'shipped', 9800, 8, '2025-10-19 20:00:00', '2025-10-20 12:00:00'),
            (5, 'processing', 5500, 5, '2025-10-20 08:45:00', '2025-10-20 08:45:00');

            insert into order_items (order_id, product_id, quantity, unit_price) values
            (1, 1, 3, 1500.00), (1, 5, 1, 2200.00), (2, 3, 4, 2200.00), (3, 7, 5, 2500.00),
            (4, 1, 2, 1600.00), (5, 8, 3, 2000.00), (5, 12, 1, 700.00), (6, 2, 2, 3550.00),
            (7, 10, 5, 1000.00), (8, 10, 3, 1000.00), (9, 1, 2, 2400.00), (10, 6, 3, 2500.00),
            (10, 11, 2, 1000.00), (11, 13, 4, 1200.00), (11, 9, 2, 1350.00), (12, 1, 5, 2500.00),
            (12, 16, 1, 1700.00), (13, 14, 2, 3000.00), (14, 11, 3, 1800.00), (15, 8, 2, 2750.00);

            insert into reviews (user_id, product_id, rating, comment, created_at) values
            (1, 1, 5, '強いホップの香りが最高！リピート確定です。', '2025-10-21 10:00:00'),
            (3, 7, 4, 'ドライなキレ味が心地よく、食後にぴったりでした。', '2025-10-22 11:30:00'),
            (2, 3, 5, 'クリーミーで甘く、本当にミルクセーキみたい！デザートに最適です。', '2025-10-23 15:00:00'),
            (4, 1, 3, '標準的なIPAですが、価格を考えると満足です。', '2025-10-24 09:15:00'),
            (5, 8, 2, 'スモーキーさが強すぎて、自分の好みではありませんでした。', '2025-10-25 18:40:00'),
            (1, 2, 5, 'ジューシーで飲みやすく、どんなシーンでも楽しめます。', '2025-10-26 14:20:00'),
            (6, 10, 4, '酸味が効いていて、夏場に最高のビール！', '2025-10-27 10:50:00'),
            (7, 15, 1, '野菜の風味が個性的すぎました。もう少し万人受けする味だと良いです。', '2025-10-28 16:10:00'),
            (8, 1, 5, '文句なしの満点。複雑な味わいなのに、飲み飽きない。', '2025-10-29 12:35:00'),
            (3, 11, 4, 'アルコールが控えめで、作業中に飲むのにちょうど良い。', '2025-10-30 20:00:00'),
            (10, 13, 5, '爽やかなハーブ感が新鮮！新しいお気に入りになりました。', '2025-10-31 08:30:00'),
            (1, 16, 4, '刺激的でインパクト大！リフレッシュしたい時に最適。', '2025-11-01 19:00:00'),
            (8, 14, 3, '少し変わった風味ですが、面白い体験でした。', '2025-11-02 11:00:00'),
            (5, 5, 4, '苦味がしっかりしていて、濃い味が好きな人におすすめ。', '2025-11-03 13:45:00'),
            (9, 4, 5, 'アルコール度数に驚きましたが、バランスが取れていて美味しい！', '2025-11-04 17:15:00');

            INSERT INTO payment_methods (name) VALUES
            ('Credit Card'), ('Cash on Delivery (COD)'), ('Bank Transfer'), ('PayPay'), ('Convenience Store Payment');

            insert into post_category (id, name, slug) values (1, 'イベント', 'event'), (2, 'ブルワリー', 'brewery'), (3, 'レビュー', 'review'),
            (4, 'ライフスタイル', 'lifestyle'), (5, 'カルチャー', 'culture'), (6, 'お知らせ', 'notice');

            INSERT INTO posts (category_id, title, slug, content, excerpt, image_url, created_at, updated_at, published_at) VALUES
            (4, '「ビールと映画の夜」ライアン・マーフィー×IPA 禁断の夜間鑑賞会', 'beer-to-eiga-no-yoru', '映画のジャンルに合わせてクラフトビールを選ぶことで、五感を刺激する“ビールと映画の夜”を演出します。特に、ライアン・マーフィー監督のダークな世界観には、苦味と香りの強いIPAが最高のマリアージュとなります。自宅での鑑賞体験をより豊かに楽しむアイデアを提案します。', '映画のジャンルに合わせてクラフトビールを選ぶことで、五感を刺激する“ビールと映画の夜”を演出し、自宅での鑑賞体験をより豊かに楽しむアイデアを提案します。', 'img/news/lifestyle/lifestyle01', '2025-09-01 10:00:00', '2025-09-01 10:00:00', '2025-09-01 10:00:00'),
            (2, '森の中のブルワリー”が語る、自然と共に醸す哲学', 'mori-no-naka-no-brewery', 'このブルワリーは、水源となる森の保全を経営哲学の中心に据えています。地域の豊かな自然環境と共生し、森の恵み（酵母、水、香り）を活かしたクラフトビール造りを行っています。彼らの持続可能な未来への思いと行動を深掘りします。', '「森の中のブルワリー」は、自然環境の保全と地域との共生を目指し、森の恵みを活かしたクラフトビール造りを通じて、持続可能な未来への思いと行動を広げている。', 'img/news/brewery/brewery01', '2025-09-01 11:30:00', '2025-09-01 11:30:00', '2025-09-01 11:30:00'),
            (5, 'クラフトビールの歴史を5分で学ぶ', 'craftbeer-rekishi-5min', '古代メソポタミアのパンから生まれた発酵飲料としての起源から、中世ヨーロッパの修道院での醸造、そして1980年代のアメリカで始まったクラフトビール革命までを駆け足で解説。5000年にわたるビールの進化を5分で旅することで、あなたを“ビール通”への第一歩へと誘う魅力的なガイドです。', '古代メソポタミアから現代日本のクラフトビール革命まで、5000年にわたるビールの進化を5分で旅することで、あなたを“ビール通”への第一歩へと誘う魅力的なガイド。', 'img/news/culture/culture01', '2025-09-01 13:00:00', '2025-09-01 13:00:00', '2025-09-01 13:00:00'),
            (1, 'SNS投稿で参加！#私の一杯 フォトコンテスト', 'sns-watashi-no-ippai-contest', '毎年恒例のフォトコンテストを今年も開催します。「#私の一杯」をテーマに、あなたが愛する一杯のクラフトビールを写真に収め、SNSでシェアしてください。豪華賞品とクラフトビール仲間とのつながりが広がる、気軽で楽しい参加型キャンペーンです。詳細は特設サイトをご覧ください。', '「SNS投稿で参加！#私の一杯 フォトコンテスト」は、あなたの“とっておきの一杯”を写真でシェアするだけで、豪華賞品とクラフトビール仲間とのつながりが広がる、気軽で楽しい参加型キャンペーンです。', 'img/news/event/event01', '2025-09-01 14:30:00', '2025-09-01 14:30:00', '2025-09-01 14:30:00'),
            (6, 'サイトリニューアル記念！限定クーポン配布中', 'sitere-newal-coupon', 'この度、当サイトはデザインと機能を一新し、より快適にクラフトビール情報を楽しんでいただけるようになりました。リニューアルを記念して、今だけ使える限定クーポンが配布中です—新しくなったページをのぞいて、お得にクラフトビールライフを始めるチャンスです！有効期限は9月30日まで。', 'サイトリニューアルを記念して、今だけ使える限定クーポンが配布中—新しくなったページをのぞいて、お得にクラフトビールライフを始めるチャンスです！', 'img/news/notice/notice01', '2025-09-01 16:00:00', '2025-09-01 16:00:00', '2025-09-01 16:00:00'),
            (5, 'クラフトビールはアートだ！デザインと哲学', 'craftbeer-art-design', 'クラフトビールの魅力は、中身の液色や香りだけではありません。ラベルに込められた造り手の思想や美学をひも解きながら、飲むだけでなく“眺めて味わう”クラフトビールの奥深い世界へと誘います。一杯の芸術論として、デザインの重要性を語ります。', 'ラベルに込められた思想や造り手の美学をひも解きながら、飲むだけでなく“眺めて味わう”クラフトビールの奥深い世界へと誘う一杯の芸術論を語ります。', 'img/news/culture/culture03', '2025-09-01 17:30:00', '2025-09-01 17:30:00', '2025-09-01 17:30:00'),
            (2, '廃校を改装したブルワリーが話題！その背景とは？', 'haikou-kaisou-brewery-topic', '鹿児島県指宿市の廃校が「いぶすきブルワリー」として生まれ変わり、地域のランドマークとなっています。地元食材を活かしたクラフトビール造りを通じて、観光拠点として地域再生を目指す、懐かしさと革新が融合した注目のプロジェクトの背景を取材しました。', '鹿児島県指宿市の廃校が「いぶすきブルワリー」として生まれ変わり、地元食材を活かしたクラフトビール造りと観光拠点として地域再生を目指す、懐かしさと革新が融合した注目のプロジェクトです。', 'img/news/brewery/brewery02', '2025-09-01 19:00:00', '2025-09-01 19:00:00', '2025-09-01 19:00:00'),
            (3, '今週の新入荷IPA、徹底レビュー！', 'new-arrival-ipa-review', 'ホップ愛好家のための特別企画として、今週新入荷したIPAの銘柄を徹底的に飲み比べ、レビューします。ホップの香りや苦味の個性を比較しながら、あなたの“次の一本”を見つけるための味覚ガイドとして、クラフトビール好きの好奇心を刺激します。', '今週の新入荷IPAを徹底レビューするこの記事は、ホップの香りや苦味の個性を比較しながら、あなたの“次の一本”を見つけるための味覚ガイドとして、クラフトビール好きの好奇心を刺激します。', 'img/news/review/review02', '2025-09-01 20:30:00', '2025-09-01 20:30:00', '2025-09-01 20:30:00'),
            (3, 'フルーツビールの魅力、甘さと酸味のバランス', 'fruit-beer-miryoku-balance', '暑い季節にぴったりのフルーツビールは、ただ甘いだけではありません。果実由来の甘さと爽やかな酸味が織りなす絶妙なハーモニーを通じて、フルーツビールが“飲むデザート”として五感を満たす魅力を紹介します。ビールの新しい楽しみ方をご提案する記事です。', '果実由来の甘さと爽やかな酸味が織りなす絶妙なハーモニーを通じて、フルーツビールが“飲むデザート”として五感を満たす魅力を紹介し、ビールの新しい楽しみ方をご提案。', 'img/news/review/review01', '2025-09-01 22:00:00', '2025-09-01 22:00:00', '2025-09-01 22:00:00'),
            (5, 'ビールのスタイル図鑑：あなたはどれが好き？', 'beer-style-zukan', 'ラガーからスタウト、サワーまで、クラフトビールには数百ものスタイルが存在します。この記事では、それら多彩なビールの個性をわかりやすく紹介し、あなたの“運命の一杯”に出会えるきっかけをくれます。飲み比べが楽しくなるガイドです。', 'ラガーからスタウト、サワーまで多彩なビールの個性をわかりやすく紹介し、あなたの“運命の一杯”に出会えるきっかけをくれる、飲み比べが楽しくなるガイドです。', 'img/news/culture/culture02', '2025-09-01 23:30:00', '2025-09-01 23:30:00', '2025-09-01 23:30:00');
        ");

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        DB::statement('DROP DATABASE IF EXISTS craftbeer_shop');
    }
};
