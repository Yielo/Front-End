<?php
class yloAvatar
{
	public function getAvatar($avatar, $id_or_email, $size = '96', $default = '', $alt = false ){
		$ylo_avatar = $avatar;
		$avatarSrc = '';
		if ( is_numeric($id_or_email) ) {
			$id = (int) $id_or_email;
			$user = get_user_by( 'id' , $id );
			$avatarSrc = $user->ylo_avatar_upload;
		}elseif ( is_object($id_or_email) ) {
			if ( ! empty( $id_or_email->user_id ) ) {
				$id = (int) $id_or_email->user_id;
				$user = get_user_by( 'id' , $id );
				$avatarSrc = $user->ylo_avatar_upload;
			}
		}elseif(is_email($id_or_email)){
			$user = get_user_by( 'email' , $id_or_email );
			$avatarSrc = $user->ylo_avatar_upload;
		}
		if(!empty($avatarSrc)){
			$ylo_avatar = "<img alt='{$safe_alt}' src='{$avatarSrc}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}

		return $ylo_avatar;
	}
}