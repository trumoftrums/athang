@extends('Layouts.frontend')

@section('content')
    <div class="list-sp-home">
        <img class="title-list-sp" src="{{ URL::asset('images/title-lienhe.png')}}"/>
        <div class="cover-list-sp">
            <p class="p-contact">
                Nông Nghiệp Lộc Ninh rất hân hạnh được tiếp nhận sự liên hệ của Quý Khách Hàng. <b class="b-nau">Chúng Tôi luôn có nhân viên trực 24/24</b> để tiếp nhận mọi thắc mắc, phản hồi và liên hệ đặt hàng từ Khách Hàng một cách nhanh chóng nhất.
                Mọi thông tin cần liên hệ xin <b class="b-nau">Quý Khách Hàng điền vào bảng bên dưới để gửi cho Chúng Tôi</b>. Chúng Tôi sẽ hỗ trợ trong thời gian ngắn nhất.
            </p>
            <p class="b-nau">..........................................................................................</p>
            <p class="email-address">Địa chỉ: 2 Nguyễn Bính, Thị Trấn Lộc Ninh, Lộc Ninh, Bình Phước, Vietnam</p>
            <p class="email-address">Email: nongnghieplocninh@gmail.com </p>
            <p class="email-address">Phone: <b class="b-red">0946 190 069</b> (gặp A.Phong)</p>
            <div class="google-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3904.9853837338196!2d106.59064831464349!3d11.836296841972326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31734c7ab3b29c87%3A0x2ccd8e828bb0b311!2zVHLhuqFtIEtodXnhur9uIE7DtG5n!5e0!3m2!1sen!2s!4v1493954659396" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                <form class="form-contact">
                    <ul>
                        <li>
                            <input placeholder="Nhập email của bạn" type="text" name="email" class="inp-contact inp-left">
                            <input placeholder="Nhập số điện thoại" type="text" name="phone" class="inp-contact inp-right">
                        </li>
                        <li>
                            <textarea placeholder="Nhập nội dung" class="area-tx" name="content"></textarea>
                        </li>
                        <li>
                            <input type="submit" class="bt-sub" value="GỬI TIN">
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
@stop