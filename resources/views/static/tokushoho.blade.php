@section('title', '特定商取引法に基づく表記')
@include('partials.header')

<main class="main">
    <section class="tokushoho l-section-top">
        <div class="c-title-level3-wrap">
            <h3 class="c-title-level3">特定商取引法に基づく表記</h3>
            <div class="c-space c-space_hidden"></div>
        </div>
        <div class="tokushoho-inner">
            <div class="tokushoho-list">
                <table>
                    <tbody>
                        <tr>
                            <th>販売業者</th>
                            <td>タキシード猫</td>
                        </tr>
                        <tr>
                            <th>運営統括責任者</th>
                            <td>雉虎　大賀</td>
                        </tr>
                        <tr>
                            <th>所在地</th>
                            <td>〒460-0000 愛知県名古屋市中区錦1-2-3 タキシードビル1F</td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>052-xxxx-xxxx</td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td>info@tuxedocat-beer.jp</td>
                        </tr>
                        <tr>
                            <th>お支払い方法</th>
                            <td>
                                <ul>
                                    <li>クレジットカード決済</li>
                                    <li>銀行振り込み</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>お支払い時期</th>
                            <td>
                                <ul>
                                    <li>クレジットカード決済: 商品ご注文時に決済が完了します。</li>
                                    <li>
                                        銀行振込:ご注文後、7日以内に指定の口座へお振り込みください。期限を過ぎた場合はキャンセルとさせていただきます。
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>商品の引渡し時期</th>
                            <td>ご注文確定後、5営業日以内に発送いたします。</td>
                        </tr>
                        <tr>
                            <th>返品・交換について</th>
                            <td>
                                <ul>
                                    <li>
                                        お客様都合による返品・交換:
                                        食品であるクラフトビールの特性上、お客様都合による返品・交換はお受けできません。
                                    </li>
                                    <li>
                                        商品に欠陥がある場合:
                                        商品到着後7日以内にご連絡ください。送料を弊社負担にて、交換または返金対応をさせていただきます。
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <nav class="c-nav c-nav_hidden">
                <ul class="c-nav-list">
                    <li><a href="{{ url('/contact') }}">お問い合わせ</a></li>
                    <li><a href="{{ url('/privacy') }}">プライバシーポリシー</a></li>
                    <li><a href="{{ url('/tokushoho') }}">特商法に基づく表記</a></li>
                </ul>
            </nav>
        </div>
    </section>
    </main>
@include('partials.footer')