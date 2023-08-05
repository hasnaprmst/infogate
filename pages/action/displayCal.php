<?php                
require_once '../auth/db_login.php'; 
$display_query = "SELECT * FROM joblist";             
$results = mysqli_query($db, $display_query);   
$count = mysqli_num_rows($results);  
if ($count > 0) {
    $data_arr = array();
    while ($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        $data = array();
        
        $data['id'] = $data_row['id'];
        $data['title'] = $data_row['job'] . "\n" . strtoupper($data_row['PIC']);
        $data['title_kategori'] = $data_row['job'];
        $data['sub_kategori'] = strtoupper($data_row['kategori']);
        $data['pic'] = strtoupper($data_row['PIC']);
        $data['start'] = date("Y-m-d", strtotime($data_row['start_date']));
        $data['end'] = date("Y-m-d", strtotime($data_row['end_date'] . ' +1 day'));
        // $data['start'] = date("Y-m-d\TH:i:s", strtotime($data_row['start_date']));
        // $data['end'] = date("Y-m-d\TH:i:s", strtotime($data_row['end_date']));
        
        if ($data_row['job'] == 'DINAS') {
            $data['color'] = '#ffc107';
        } else if ($data_row['job'] == 'TUGAS') {
            $data['color'] = '#28a745';
        } else if ($data_row['job'] == 'RAPAT') {
            $data['color'] = '#dc3545';
        }

        $data['grup'] = strtoupper($data_row['grup']);
        $data['judul'] = strtoupper($data_row['judul']);
        $data['deskripsi'] = strtoupper($data_row['deskripsi']);

        $data_arr[] = $data;
    }
    
    $response = array(
        'status' => true,
        'msg' => 'successfully!',
        'data' => $data_arr
    );
} else {
    $response = array(
        'status' => false,
        'msg' => 'Error!'				
    );
}

echo json_encode($response);
?>
