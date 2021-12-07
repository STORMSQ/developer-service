<?php
namespace STORMSQ\Developer;
use Request;
class PresenterBuilder{

    public function getTableHeader(array $head = [])
    {
        $html="";
        $current =url()->current()."?";
        $query = $this->newUrl();
        foreach ($head as $key=>$row) {
            $html.='<th>';
            $key = preg_replace('/(.+)\[[0-9]+\]/Ux', '\\1', $key);
            if(strpos($query,'by=asc')!=false){
                if(Request::get('sort')==$key){
                    $icon = config('developer.presenter.icon.asc');
                }else{
                    $icon = config('developer.presenter.icon.default');
                }
                $href= $current.str_ireplace('asc','desc',preg_replace('/(sort=).*(&)/Ux','sort='.$key.'\\2',$query));

                $html.='<a href="'.$href.'">'.((config('developer.presenter.icon.useitag'))?'<i class="'.$icon.'"></i>':null).$row.'</a>';	              
            }elseif(strpos($query,'by=desc')!=false){
                if(Request::get('sort')==$key){
                    $icon = config('developer.presenter.icon.desc');
                }else{
                    $icon = config('developer.presenter.icon.default');
                }
                $href= $current.str_ireplace('asc','desc',preg_replace('/(sort=).*(&)/Ux','sort='.$key.'\\2',$query));
                $html.='<a href="'.$href.'" >'.((config('developer.presenter.icon.useitag'))?'<i class="'.$icon.'"></i>':null).$row.'</a>';	              
            }else{
                $icon = config('developer.presenter.icon.default');
                $href= $current.str_ireplace('asc','desc',preg_replace('/(sort=).*(&)/Ux','sort='.$key.'\\2',$query));
                $html.='<a href="'.$href.'&sort='.$key.'&by=desc" >'.((config('developer.presenter.icon.useitag'))?'<i class="'.$icon.'"></i>':null).$row.'</a>';	              
            }   
            $html.='</th>';

        }
        return $html;
    }
    public function newUrl(array $query= [],array $remove=[])
    {
        $request = request();
        $original = url()->current();
        
        $request->request->add($query);
        foreach($remove as $row){
            $request->request->remove($row);
        }
       
        
        return $this->map($request->all());
    }
    public function map(array $data,$preKey=null)
    {
        $map = collect($data)->map(function($item,$key)use($preKey){
            if(is_array($item)){
               $nextKey = ($preKey)?$preKey."[".$key."]":$key;
               return $this->map($item,$nextKey);
            }else{
                return (($preKey)?$preKey."[".$key.']':$key).'='.$item; 
            }
               
        });
        return implode("&",$map->toArray());

    }
}