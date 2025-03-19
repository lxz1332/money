<?php

namespace cwkj\money;

use think\facade\Db;

class Money {
 
    public function add($user_id, $style, $money, $content, $cate = 1, $time = 0) {
        $map['user_id'] = $user_id;
        $name = 'user_money' . $style;
        if (Db::name("user")->where($map)->inc("$name", $money)->update()) {
            $status = self::add_money($user_id, $style, $money, $content, $cate, $time);
            if (!$status) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function add_money($user_id, $money_style, $money_money, $money_content, $money_cate2, $time) {
        $data = array(
            'money_bianhao' => date("ymdHis") . $user_id . rand(100, 999),
            'user_id' => $user_id,
            'money_cate' => $money_money >= 0 ? 1 : 2,
            'money_cate2' => $money_cate2,
            'money_money' => $money_money,
            'money_content' => $money_content,
            'money_time_add' => $time ? $time : time(),
        );
        if ($money_style == 1) {
            $name = 'money';
        } else {
            $money_style = $money_style - 1;
            $name = 'money' . $money_style;
        }
        if (Db::name("$name")->insert($data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
