<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use Image;
use DB;

class PlaylistController extends Controller
{
    public function GetSongData(){

        $playlist =  DB::table('playlist')
                        ->orderBy('ID','DESC')
                        ->get();
        return response()->json($playlist);

    }

    public function SaveMusic(Request $request){
        $songtitle = $request->title;
        $artistname = $request->artistname;
        $musicfile = $request->musicfile;
        $musicimage = $request->musicimage;
        $key = time();

        $validateData = $request->validate([
            'title' => 'required|unique:playlist|max:90',
        ],
        [
            'title.unique' => 'This song title has been taken',
        ]);
       

        $upload_path_song = 'backend/musicapidata/music/'; 
        $upload_path_image = 'backend/musicapidata/images/';

        $file_name_song = $request->musicfile->getClientOriginalName();
        $file_name_image = $request->musicimage->getClientOriginalName();

        $generated_new_name_song = $key.'_'.$songtitle. '_song.' . $request->musicfile->getClientOriginalExtension();
        $generated_new_name_image = $key .'_'.$songtitle. '_image.' . $request->musicimage->getClientOriginalExtension();

        $request->musicfile->move($upload_path_song, $generated_new_name_song);
        $request->musicimage->move($upload_path_image, $generated_new_name_image);

        $songurl = env('APP_URL_SONG').$upload_path_song.$generated_new_name_song;
        $songposter = env('APP_URL_SONG').$upload_path_image.$generated_new_name_image;

        $playlist = new Playlist;

        $playlist->playlist = ucwords($songtitle);
        $playlist->title = ucwords($songtitle);
        $playlist->artist = ucwords($artistname);
        $playlist->songurl = $songurl;
        $playlist->poster = $songposter;
        $playlist->key = $key;
        $playlist->date = date('d/m/Y');
        $playlist->time = date("h:i:sa");
        $playlist->save();

    }


    // edit music api
    public function EditMusic(Request $request, $id){

        $playlist = DB::table('playlist')->where('id',$id)->first();

        $songtitle = $request->title;
        $artistname = $request->artistname;
        $musicimage = $request->musicimage;
        $key = time();

        if($playlist->title != $songtitle){
            $validateData = $request->validate([
                'title' => 'required|unique:playlist|max:90',
            ],
            [
                'title.unique' => 'This song title has been taken',
            ]);
        }

        
       


        $upload_path_song = 'backend/musicapidata/music/'; 
        $upload_path_image = 'backend/musicapidata/images/';

        if($musicimage == 'undefined'){ //dont update image

            $posterdir = ltrim($playlist->poster, env('APP_URL_SONG'));
            //unlink($posterdir); //delete image file from file explorer (image)

            $songext = substr(strrchr($playlist->songurl,'.'),1);
            $imgext = substr(strrchr($playlist->poster,'.'),1);

            $generated_new_name_song = $key.'_'.$songtitle. '_song.' . $songext;
            $generated_new_name_image = $key .'_'.$songtitle. '_image.' . $imgext;

            $musicdir = ltrim($playlist->songurl, env('APP_URL_SONG'));
            $musicdirfull = ltrim($musicdir,"backend/musicapidata/music/");

            $imagedir = ltrim($playlist->poster, env('APP_URL_SONG'));
            $imagedirfull = ltrim($imagedir,"backend/musicapidata/images/");

            rename($upload_path_song.$musicdirfull,$upload_path_song.$generated_new_name_song); //rename file in file explorer (music)
            rename($upload_path_image.$imagedirfull, $upload_path_image.$generated_new_name_image);

            $songurl = env('APP_URL_SONG').$upload_path_song.$generated_new_name_song;
            $songposter = env('APP_URL_SONG').$upload_path_image.$generated_new_name_image;

            $data = array();
            $data['playlist'] = $songtitle;
            $data['title'] = $songtitle;
            $data['artist'] = $artistname;
            $data['songurl'] = $songurl;
            $data['poster'] = $songposter;
            $data['key'] = $key;
            $data['date'] = date('d/m/Y');
            $data['time'] = date("h:i:sa");

            $user = DB::table('playlist')->where('id',$id)->update($data); //update all data in database

        }else{

            
        $posterdir = ltrim($playlist->poster, env('APP_URL_SONG'));
        unlink($posterdir); //delete image file from file explorer (image)

        $songext = substr(strrchr($playlist->songurl,'.'),1);

        $generated_new_name_song = $key.'_'.$songtitle. '_song.' . $songext;
        $generated_new_name_image = $key .'_'.$songtitle. '_image.' . $request->musicimage->getClientOriginalExtension();

        $musicdir = ltrim($playlist->songurl, env('APP_URL_SONG'));
        $musicdirfull = trim($musicdir,"backend/musicapidata/music/");

        rename($upload_path_song.$musicdirfull,$upload_path_song.$generated_new_name_song); //rename file in file explorer (music)
        $request->musicimage->move($upload_path_image, $generated_new_name_image);

        $songurl = env('APP_URL_SONG').$upload_path_song.$generated_new_name_song;
        $songposter = env('APP_URL_SONG').$upload_path_image.$generated_new_name_image;


        $data = array();
        $data['playlist'] = $songtitle;
        $data['title'] = $songtitle;
        $data['artist'] = $artistname;
        $data['songurl'] = $songurl;
        $data['poster'] = $songposter;
        $data['key'] = $key;
        $data['date'] = date('d/m/Y');
        $data['time'] = date("h:i:sa");

    
        $user = DB::table('playlist')->where('id',$id)->update($data); //update all data in database

        }
 



    }

    public function Destroy($songId)
    {
        $playlistcount = Playlist::all(); //we would get back an array
        $totalsong = count($playlistcount);

        if($totalsong == 1){
            $serveresponse = array(
                'status' => 'false',
                'message' => 'Unable to delete song. You must have at least a song on the player'
            );
            return response()->json($serveresponse);
            exit();
        }

        

        $id = $songId;
        $playlist = DB::table('playlist')->where('id',$id)->first();
        $posterdir = ltrim($playlist->poster, env('APP_URL_SONG'));
        $songdir = ltrim($playlist->songurl, env('APP_URL_SONG'));

        $deletesong = DB::table('playlist')->where('id', $id)->delete();
        if(!unlink($posterdir)){
            $serveresponse = array(
                'status' => 'false',
                'message' => 'Unable to delete music image (jpg)'
            );
            return response()->json($serveresponse);
            exit();
        }

        if(!unlink($songdir)){
            $serveresponse = array(
                'status' => 'false',
                'message' => 'Unable to delete song (mp3)'
            );
            return response()->json($serveresponse);
            exit();
        }

        if($deletesong){
            $serveresponse = array(
                'status' => 'success',
                'message' => 'Deleted successfully'
            );
            return response()->json($serveresponse);
        }
        

        
    }


}
