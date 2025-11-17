<?php

namespace Database\Seeders;

use App\Enums\Setting\SettingGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Setting\SettingTypeInput;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'setting_key' => 'favicon',
                'setting_name' => 'Favicon',
                'plain_value' => '/public/assets/images/firstdate-icon-circle.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'logo',
                'setting_name' => 'Logo',
                'plain_value' => '/public/assets/images/firstdate-icon-default.png',
                'type_input' => SettingTypeInput::Image,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'address',
                'setting_name' => 'Địa chỉ:',
                'plain_value' => 'text',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'hotline',
                'setting_name' => 'Số điện thoại:',
                'plain_value' => '0707070444',
                'type_input' => SettingTypeInput::Phone,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'zalo',
                'setting_name' => 'Zalo:',
                'plain_value' => '0707070444',
                'type_input' => SettingTypeInput::Phone,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'male_deposit_rate',
                'setting_name' => 'Mức tiền cọc người nam: ',
                'plain_value' => '150',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'female_deposit_rate',
                'setting_name' => 'Mức tiền cọc người nữ: ',
                'plain_value' => '50',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'lgbt_deposit_rate',
                'setting_name' => 'Mức tiền cọc cùng giới: ',
                'plain_value' => '100',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'transportation_support_rate',
                'setting_name' => 'Mức tiền hỗ trợ đi lại: ',
                'plain_value' => '50',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'profit_split',
                'setting_name' => 'Phần trăm triết khấu:',
                'plain_value' => '2',
                'type_input' => SettingTypeInput::Number,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'information',
                'setting_name' => 'Thông tin giới thiệu',
                'plain_value' => 'html',
                'type_input' => SettingTypeInput::Ckeditor,
                'group' => SettingGroup::General
            ],
            [
                'setting_key' => 'policy',
                'setting_name' => 'Điều khoản - chính sách',
                'plain_value' => 'html',
                'type_input' => SettingTypeInput::Ckeditor,
                'group' => SettingGroup::General
            ],
            //payment
            [
              'setting_key' => 'qr_code',  
              'setting_name' => 'QR code',
              'plain_value' => '/public/assets/images/qr-code.png',
              'type_input' => SettingTypeInput::Image,
              'group' => SettingGroup::Payment,
            ],
            [
                'setting_key' => 'account_name',
                'setting_name' => 'Tên chủ tài khoản',
                'plain_value' => 'Mevivu',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Payment,
            ],
            [
                'setting_key' => 'account_number',
                'setting_name' => 'Số tài khoản',
                'plain_value' => '123456789',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Payment,
            ],
            [
                'setting_key' => 'bank_name',
                'setting_name' => 'Ngân hàng',
                'plain_value' => 'Vietinbank',
                'type_input' => SettingTypeInput::Text,
                'group' => SettingGroup::Payment,
            ],
            //theme
            [
                'setting_key' => 'bg_color',
                'setting_name' => 'Màu nền chung:',
                'plain_value' => '#ffffff',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'top_sidebar_text_color',
                'setting_name' => 'Màu chữ top sidebar:',
                'plain_value' => '#000000',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'top_sidebar_bg_color_1',
                'setting_name' => 'Màu top sidebar 1:',
                'plain_value' => '#e8edf1',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'top_sidebar_bg_color_2',
                'setting_name' => 'Màu top sidebar 2:',
                'plain_value' => '#ffd166',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'left_sidebar_text_color',
                'setting_name' => 'Màu chữ left sidebar:',
                'plain_value' => '#ffffff',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'left_sidebar_selected_color',
                'setting_name' => 'Màu left sidebar khi được chọn:',
                'plain_value' => '#B8E4E4',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'left_sidebar_selected_text_color',
                'setting_name' => 'Màu chữ left sidebar khi được chọn:',
                'plain_value' => '#383838',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'left_sidebar_bg_color_1',
                'setting_name' => 'Màu left sidebar 1:',
                'plain_value' => '#141618',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'left_sidebar_bg_color_2',
                'setting_name' => 'Màu left sidebar 2:',
                'plain_value' => '#0c367a',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'breadcrumbs_text_color',
                'setting_name' => 'Màu chữ breadcrumbs:',
                'plain_value' => '#ffffff',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'breadcrumbs_bg_color_1',
                'setting_name' => 'Màu breadcrumbs 1:',
                'plain_value' => '#141618',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
            [
                'setting_key' => 'breadcrumbs_bg_color_2',
                'setting_name' => 'Màu breadcrumbs 2:',
                'plain_value' => '#0c367a',
                'type_input' => SettingTypeInput::Color,
                'group' => SettingGroup::CMSTheme
            ],
        ]);
    }
}
