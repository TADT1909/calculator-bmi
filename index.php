<?php
// Hàm trả kết quả theo chuẩn json để chatfuel đọc được
function isTraKetQua ($kq, $thongbao)
{
	$mss  = array
	(
		'text' => 'Chỉ số BMI của bạn là: ' .$kq.' - '. $thongbao);
	$response = array
	(
		'messages' => array($mss)
		);
	return json_encode ($response);
}


// Kiểm ra xem người dùng có input chỉ số hay không?
if( isset($_GET['chiso']) ) 
{
	// xử lý biến đầu vào và tách nó ra làm 2 phần được phân định bởi dấu _
	$tmp = explode('_', $_GET['chiso']);
	//echo $tmp[0]. '---' .$tmp[1];
	
	// Công thức tính BMI: căn nặng / chiều cao * chiều cao
	$ketqua = (int)$tmp[0] / ( (int)$tmp[1]/100 * (int)$tmp[1]/100);
	
	// làm tròn 2 số thập phân cho đẹp
	$ketqua = round($ketqua, 2);
	
	// ghi log input đầu vào của User
	$file = fopen("log-chisi_BMI.txt",'a+');
	fwrite($file,$_GET['chiso']);
	fwrite($file,"\n");
	fclose($file);
	
	// cấu trúc rẽ nhánh cho từng chỉ số BMI
	if ($ketqua < 18.5)
	{
		// Kết quả trả về sẽ là: Chỉ số BMI của bạn là: 18 - Ốm
		echo isTraKetQua($ketqua, 'Ốm');
	}
	elseif ( ($ketqua >= 18.5) && ($ketqua <= 22.9) )
	{	
		echo isTraKetQua($ketqua, 'Cân đối');
	}
	elseif ( ($ketqua >= 23) && ($ketqua <= 24.9) )
	{
		echo isTraKetQua($ketqua, 'Sắp béo phì');
	}
	elseif ( ($ketqua >= 25) && ($ketqua <= 29.9) )
	{
		echo isTraKetQua($ketqua, 'Béo phì');
	}
	elseif ( $ketqua >= 30 )
	{
		echo isTraKetQua($ketqua, 'Quá béo phì');
	}
	else
	{
		// Cài cho vui.
		echo 'Em chưa tìm ra kết quả';
		return;
	}
}
else
{
	// Nếu người dùng không input vào ban đầu thì hiện thị cái câu phía dưới ra.
	echo 'điền đi';
	return;
}
?>
