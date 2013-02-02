<?php


class posts
{
	public $db;
	public $mem;
	public $name;
	public $pic;
	public $cat = 0;
	public $lang;
	
	public function createForm()
	{
		
			echo'
			
			<div id="postsArea">	
				<table>
					<tr>
					<td><img src="'.$this->pic.'"  width="90" height="90" class="tipped" title="'.$this->name.'" /></td>
					<td><textarea class="textarea" id="post" name="post"></textarea></td>
					</tr>
					<tr><td colspan="2">
						<table>
						<tr><td style="width: 190px;">	
						<input type="dropbox-chooser" name="selected-file" id="db-chooser"/>
						</td>
						<td>
							<a href="#" id="addPhotos"><img src="gfx/camera.png" /></a>
						</td>
						<td style="width: 250px; text-align: right;">
						<label>
							<select id="cat" name="cat">';
							
							$tmp = $this->db->query("SELECT * FROM categories");
							
							while($tmp2 = $tmp->fetch_assoc())
							{
								
								echo '<option value="'.$tmp2['id'].'">'.$tmp2['name'].'</option>';
							
							}							
							
							
			echo		'	</select>
						</label>
						</td>
						<td style="width: 120px; text-align: right;">
							<a href="#" class="big" id="addPost">Add</a>
						</td>
						</tr>
						</table>
					</td>
					</tr>
					<tr><td colspan="2"><br />
					<div id="startUploadPhoto">
					    <form>
						    <div id="queue"></div>
						    <br />
						    <div style="position: relative; left: 230px;""><input id="file_upload" name="file_upload" type="file" multiple="true"></div>
					    </form>
					    <br />
					    <div id="preview"></div>
					</div>
					</td></tr>
				</table><br /><br />
			</div>
		
			';	
	}
	
	
	public function fetchUsers($id)
	{
		
		if(isset($this->mem))
		{
			$sql   = "SELECT * FROM users WHERE id='$id' LIMIT 1";
			$key    = md5('stanley'.$sql);
			$data3  = $this->mem->get($key);
			
			if(!$data3)
			{
				
				$half = $this->db->query($sql)->fetch_assoc();	
				$this->mem->set($key, $half, MEMCACHE_COMPRESSED, 864000);
				$data3 = $this->mem->get($key); 
			}
			
			return $data3;
			
		}
		
	}
	
	public function fetchComments($pid)
	{
		if($pid>0)
		{			
			echo '<div id="mainComments'.$pid.'">';
			
			if(isset($this->mem))
			{				
				$sql     =  "SELECT * FROM comments WHERE pid='$pid' ORDER BY date";
				$key     =  md5('stanley'.$sql);
				$data2    =  $this->mem->get($key);
				
				if(!$data2)
				{
					$tmp_arr = array();
					$ii		 = 0;
					$half	 = $this->db->query($sql);
					
					while($tmp = $half->fetch_assoc())
					{
						$tmp_arr[$ii] = $tmp;
						$ii++;
					}
					
					$this->mem->set($key, $tmp_arr, MEMCACHE_COMPRESSED, 864000);
					$data2 = $this->mem->get($key); unset($tmp_arr);
				}
				
				
				
				if(count($data2)>0)
				{
					
					$ii = 0;					
					
					while(@$data2[$ii])
					{
						
						$userFetch = $this->fetchUsers($data2[$ii]['uid']);
						
						if(strlen(@$userFetch['img'])>0)	$pic = $userFetch['img']; else $pic = 'gfx/faces/23.png';
						if(strlen(@$userFetch['fname'])>0 && strlen($userFetch['sname'])>0) $name = $userFetch['fname'].' '.$userFetch['sname']; else $name = $userFetch['zhname'];
						
						
						echo '<div class="comment" id="comment'.$data2[$ii]['id'].'">
							 <table celpadding="0" cellspacing="0">
							 	<tr>
								<td><img src="'.$pic.'" width="25" height="25" class="tipped" title="'.$name.'" /></td>
								<td>'.$data2[$ii]['body'].'</td>	
								</td>
							 </table>									
							 </div>';
						
						$ii++;
					}
				}
			
			}
		
			echo '</div>';
		}
	}
	
	public function fetchPosts()
	{
		
		echo '<div id="postMain">';
			
		if(isset($this->mem))
		{
				if(@$this->cat == 0)
					$sql    = "SELECT * FROM posts ORDER BY date DESC";
				else
					$sql	= "SELECT * FROM posts WHERE cat='".$this->cat."' ORDER BY date DESC"; 
						
				$key     =  md5('stanley'.$sql);
				$data    =  $this->mem->get($key);
				
				if(!$data)
				{
					 $tmp_arr  =   array();
					 $i        =   0;
					 $half     =   $this->db->query($sql);
					 
					 while($tmp = $half->fetch_assoc())
					 {
						 $tmp_arr[$i] = $tmp;
						 $i++;
					 }
						 
					 $this->mem->set($key, $tmp_arr, MEMCACHE_COMPRESSED, 864000);
					 $data = $this->mem->get($key); unset($tmp_arr);

                    unset($tmp);
				}
				
				if(count($data)>0)
				{
				
					$i = 0;
					
					while(@$data[$i])
					{

                        $pid = $data[$i]['id'];
                        $cat = $data[$i]['cat'];
						$cat = $this->db->query("SELECT * FROM categories WHERE id='$cat' LIMIT 1")->fetch_assoc();
						
						echo '<div class="post" id="post'.$data[$i]['id'].'">
								<table celpadding="0" cellspacing="0">
									<tr>
										<td><img src="'.$this->pic.'"  width="30" height="30" /></td>
										<td style="width:550px; text-align: left;">'.$this->name.'
										<br />
										<span class="dateFormat">'.$data[$i]['date'].'</span>
										</td>
										<td><a href="#" onclick="deletePost('.$data[$i]['id'].','.$data[$i]['cat'].')"><img src="gfx/x.gif" /></a></td>
									</tr>
									<tr>
										<td valign="top"><div style="background:'.$cat['color'].';, width: 30px; height: 30px; color: white; font-size: 23px; text-align: center;">'.substr(ucfirst($cat['name']),0, 1).'</div></td>
										<td colspan="2" class="postBody">'.$data[$i]['body'].'</td>
									</tr>';

                                    if($data[$i]['files'] == 1)
                                    {
                                        echo '<tr><td></td><td colspan="2" style="width: 500px; text-align: center;">';

                                        $tmp = $this->db->query("SELECT * FROM images WHERE pid='$pid'");

                                        while($tmp2 = $tmp->fetch_assoc())
                                        {
                                            echo '<a href="'.str_replace('_cube_', '_optim_', $tmp2['linkCube']).'" class="lightview" data-lightview-group="group'.$pid.'"><img src="'.$tmp2['linkCube'].'" /></a> ';
                                        }
                                        unset($tmp, $tmp2);
                                        echo '</td></tr>';
                                    }

				        echo		'<tr>
										<td></td>
										<td colspan="2"><div id="commentSpace">';
										
										$this->fetchComments($data[$i]['id']);
										
						echo			'</div></td>
									</tr>
									<tr>
										<td valign="top" align="center"><img src="gfx/comment.png" /></td>
										<td colspan="2">

												<table celpadding="0" cellspacing="0">
												<tr>
													<td colspan="2">
													<div id="newComment'.$pid.'"></id>
													</td>
												</tr>		
												<tr>
													<td><img src="'.$this->pic.'" width="25" height="25" /></td>
													<td><input type="text" id="commentBody'.$pid.'" name="commentBody'.$pid.'" class="commentBody" onkeypress="return addcomment(event, '.$pid.')" /></td>
												</tr>
												</table>

										</td>
									</tr>		
								</table>
							  </div><br />';
										
						$i++;				
					}	
				}	
		}		
		
		
			
		echo '</div>';
		unset($tmp);		
	
	}
	
	public function create()
	{
		$this->createForm();
		$this->fetchPosts();
		
	}
	
}