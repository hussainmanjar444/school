<?php 
 
namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
class CommonController extends Controller
{

	public function actionGetDistrict($id)
	{
		$posts = \app\models\District::find()
				->where(['province_id' => $id])
				->orderBy('name ASC')
				->all();
				
		if (!empty($posts)) {
			foreach($posts as $post) {
				echo "<option value='".$post->id."'>".$post->name."</option>";
			}
		} else {
			echo "<option>- Select a district</option>";
		}
	}

	public function actionGetMunicipality($id)
	{
		$posts = \app\models\Municipality::find()
				->where(['district_id' => $id])
				->orderBy('name ASC')
				->all();
				
		if (!empty($posts)) {
			foreach($posts as $post) {
				echo "<option value='".$post->id."'>".$post->name."</option>";
			}
		} else {
			echo "<option>- Select a municipality</option>";
		}
	}


	public function actionCheckDuplicateUser($email)
	{
		if($email)
		{
			$user = \app\models\User::find()->where(['email' => $email])->one();
			if($user)
			{
				echo "<img src='/uploads/found.png' style='width:35px;height:30px'> <b style='color:red'>Email already in used. Try with another email.</b>";
			}
			else
			{
				echo "<img src='/uploads/not-found.png' style='width:35px;height:30px'> <b style='color:green'>You can used this email to create school.</b>";
			}
		}
		else{
			echo "";
		}
	}


	public function actionGetLibraryRoom($id)
	{
		$posts = \app\models\LibraryRoom::find()
				->where(['school_id' => $id])
				->orderBy('name ASC')
				->all();
				
		if (!empty($posts)) {
			foreach($posts as $post) {
				echo "<option value='".$post->id."'>".$post->name."</option>";
			}
		} else {
			echo "<option>- Select a room</option>";
		}
	}

	public function actionGetLibraryRoomRack($id)
	{
		$posts = \app\models\LibraryRoomRack::find()
				->where(['room_id' => $id])
				->orderBy('name ASC')
				->all();
				
		if (!empty($posts)) {
			foreach($posts as $post) {
				echo "<option value='".$post->id."'>".$post->name."</option>";
			}
		} else {
			echo "<option>- Select a rack</option>";
		}
	}
}
?>