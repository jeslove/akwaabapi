<?php 

namespace core\Photos;

class Photos 
{
	private static $filename;
    
    private static function tempnam_sfx($path, $suffix)
    {
        do {
            $file = $path . "/" . mt_rand() . $suffix;

            $fp = @fopen($file, 'x');
        } while (!$fp);

        fclose($fp);

        return $file;
	}
	
	public static function set_image($photo, $location)
    {
		if(isset($_FILES["$photo"]) && $_FILES["$photo"]["error"] == 0)
		{
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

            self::$filename = $_FILES["$photo"]["name"];

            $filetype = $_FILES["$photo"]["type"];

            $filesize = $_FILES["$photo"]["size"];
        
            // Verify file extension
            $ext = pathinfo(self::$filename, PATHINFO_EXTENSION);             

            if(!array_key_exists($ext, $allowed))
            {
                echo json_encode(['status'=>'error', 'message'=>'Please select a valid file format.']);
            } 
        
            // Verify file size - 5MB maximum
            
            $maxsize = 5 * 1024 * 1024;

            if($filesize > $maxsize)
            {
                echo json_encode(['status'=>'error', 'message'=>'File size is larger than the allowed limit']);
            }
        
            // Verify MYME type of the file
			if(in_array($filetype, $allowed))
			{
				self::$filename = self::tempnam_sfx($location, ".webP");

                move_uploaded_file($_FILES["$photo"]["tmp_name"], self::$filename); 

                // return (!empty(self::$filename))? self::$filename : false;

                if(!empty(self::$filename))
                {
                    return self::$filename; 
                }
			} 
			else
			{
                echo json_encode(['status'=>'error', 'message'=>'Something want wrong']);
			}
		}
		else
		{
            echo json_encode(['status'=>'error', 'message'=>'Something want wrong']);
        }  
    }

    public static function set_multiple($photo,$location)
    {
        if(isset($_FILES["$photo"]))
		{
			if(count($_FILES["$photo"]["name"]) > 0)
			{
				foreach($_FILES["$photo"]["error"] as $error)
                {
                    if($error)
                    {
                        echo json_encode(['status'=>'error','message'=>$error]);
						exit();
                    }          		
                }

				$maxsize = 2 * 1024 * 1024; //2MB maximum allowed.

				foreach($_FILES["$photo"]["size"] as $size)
                {
                    if($size > $maxsize)
                    {
                        echo json_encode(['status'=>'error','message'=>'File size is larger than the allowed limit (2mb)']);
						exit();
                    }          		
                }

				$allowed = array( 'jpg', 'jpeg','png');

				foreach($_FILES["$photo"]['name'] as $name)
                {
                    $type = pathinfo($name, PATHINFO_EXTENSION);

                    if(!in_array($type, $allowed))
                    {
						echo json_encode(['status'=>'error','message'=>'Please select a valid file format']);
						exit();
                    }       	
                }

				$total = count($_FILES["$photo"]['name']);

				if($total > 5)
                {
					echo json_encode(['status'=>'error','message'=>'You have exceed the post limit (5 picture per post)']);
					exit();
                }
				else
				{
					for( $i=0 ; $i < $total ; $i++ )
					{
						//The temp file path is obtained
						$tmpFilePath = $_FILES["$photo"]['tmp_name'][$i];

						//A file path needs to be present
						if ($tmpFilePath != "")
						{
						   //Setup our new file path
						   $newFilePath = $location."/" . $_FILES["$photo"]['name'][$i];

						   //File is uploaded to temp dir
						   if(move_uploaded_file($tmpFilePath, $newFilePath))
						   {
							   return $newFilePath;
						   }
                           else
                           {
                                echo json_encode(['status'=>'error','message'=>'Oops! Something want wrong.']);
                                exit();
                           }
					    }
				    }
				}
			}
		}
    }
}