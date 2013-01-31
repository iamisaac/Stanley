<?php


class posts
{
	public $db;
	public $mem;
	public $name;
	public $pic;
	public $cat = 1;
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
						<tr><td style="width: 400px;">	
						<input type="dropbox-chooser" name="selected-file" id="db-chooser"/>
						</td>
						<td style="width: 300px; text-align: right;">
						<select id="cat" name="cat" class="selection">';
							
							$tmp = $this->db->query("SELECT * FROM categories");
							
							while($tmp2 = $tmp->fetch_assoc())
							{
								
								echo '<option value="'.$tmp2['id'].'">'.$tmp2['name'].'</option>';
							
							}							
							
							
			echo		'</select>
						<a href="#" class="big" id="addPost">Add</a>
						</td>
						</tr>
						</table>
					</td>
					</tr>
				</table><br /><br /><br />
			</div>';	
	}
	
	public function fetchUsers($id)
	{
		
		if(isset($this->mem))
		{
			$sql   = "SELECT * FROM users WHERE id='$id'";
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
				if(@$this->cat == 1)
					$sql    = "SELECT * FROM posts ORDER BY date DESC";
				else
					$sql	= "SELECT * FROM posts WHERE cat='$cat' ORDER BY date DESC"; 
						
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
					
				}
				
				if(count($data)>0)
				{
				
					$i = 0;
					
					while(@$data[$i])
					{
						
						echo '<div class="post" id="post'.$data[$i]['id'].'">
								<table celpadding="0" cellspacing="0">
									<tr>
										<td><img src="'.$this->pic.'"  width="30" height="30" /></td>
										<td style="width:550px; text-align: left;">'.$this->name.'</td>
										<td><a href="#" onclick="deletePost('.$data[$i]['id'].')"><img src="gfx/x.gif" /></a></td>
									</tr>
									<tr>
										<td></td>
										<td colspan="2" class="postBody">'.$data[$i]['body'].'<br /><br /></td>
									</tr>
									<tr>
										<td></td>
										<td colspan="2">';
										
										$this->fetchComments($data[$i]['id']);
										
						echo			'</td>
									</tr>
									<tr>
										<td></td>
										<td colspan="2">

												<table celpadding="0" cellspacing="0">
												<tr>
													<td colspan="2">
													<div id="newComment'.$data[$i]['id'].'"></id>
													</td>
												</tr>		
												<tr>
													<td><img src="'.$this->pic.'" width="25" height="25" /></td>
													<td><input type="text" id="commentBody'.$data[$i]['id'].'" name="commentBody'.$data[$i]['id'].'" class="commentBody" onkeypress="return addcomment(event, '.$data[$i]['id'].')" /></td>
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
		
		echo '
		<!-- adding script for posts -->
		<script type="text/javascript" src="js/posts.js"></script>
		<!-- end -->
		';
	}
	
}