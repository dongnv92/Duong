<?php

class functionDuong{

    public function redirectUrl($url){
        return header('location:'.$url);
    }

    // Tạo Mã Token
    public function createToken(){
        return md5(md5(_CONFIG_TOKEN_KEYSTART._CONFIG_TIME._CONFIG_TOKEN_KEYSEND));
    }

    // Kiểm tra mã token
    public function checkToken($token){
        $arr_token = array();
        for ($i = 0; $i <= _CONFIG_TIMETOKEN; $i++){
            $time_c         = _CONFIG_TIME - $i;
            $arr_token[]    = md5(md5(_CONFIG_TOKEN_KEYSTART.$time_c._CONFIG_TOKEN_KEYSEND));
        }
        if(in_array($token, $arr_token)){
            return true;
        }else{
            return false;
        }
    }

    private function createPaginationUrl($url, $page){
        $url = str_replace('{page}', $page, $url);
        return $url;
    }

    public function pagination($config = ''){
        $link = '';
        global $page;
        for($i=$page;$i<=($page+4) && $i<= $config['page_num'] ;$i++){
            if($page==$i){
                $link = '<li class="page-item active"><a href="javascript:;" class="page-link">'.$i.'</a></li>';
            }else{
                $link = $link.'<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], $i) .'" class="page-link">'.$i.'</a></li>';
            }
        }
        if($page>4){
            $page4 = '<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], ($page-4)) .'" class="page-link">'.($page-4).'</a></li>';
        }
        if($page>3){
            $page3 = '<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], ($page-3)) .'" class="page-link">'.($page-3).'</a></li>';
        }
        if($page>2){
            $page2 = '<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], ($page-2)) .'" class="page-link">'.($page-2).'</a></li>';
        }
        if($page>1){
            $page1 = '<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], ($page-1)) .'" class="page-link">'.($page-1).'</a></li>';
            $link1 = '<li class="page-item" class="page-link" aria-label="Previous"><a href="'. $this->createPaginationUrl($config['url'], ($page-1)) .'" class="page-link"><span aria-hidden="true">« Trang sau</span><span class="sr-only">Previous</span></a></li>';
        }
        if($page < $config['page_num']){
            $link2 = '<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], ($page+1)) .'" class="page-link" aria-label="Next"><span aria-hidden="true">Trang tiếp »</span><span class="sr-only">Next</span></a></li>';
        }
        $linked = $page4.$page3.$page2.$page1;
        if($page < $config['page_num']-4){
            $page_end_pt='<li class="page-item"><a href="'. $this->createPaginationUrl($config['url'], $config['page_num']) .'" class="page-link">'.$config['page_num'].'</a></li>';
        }
        if($page>5){
            $page_start_pt =' <li class="page-item"><a href="'.$config['url'].'" class="page-link">1</a></li>';
        }
        if($config['page_num']>1 && $page<=$config['page_num']){
            return '<ul class="pagination justify-content-center pagination-separate">'.$link1.$page_start_pt.$linked.$link.$page_end_pt.$link2.'</ul>';
        }else{
            return false;
        }
    }
}


