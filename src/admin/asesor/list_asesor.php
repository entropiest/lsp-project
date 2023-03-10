<!-- panggil config -->
<?php require "../../../config/config.php"?>

<!DOCTYPE html>
<html>
<head>
    <title>View Data Asesor</title>
    <link rel="stylesheet" href="../../../assets/css/dashboard_style.css">
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/021b758c3a.js" crossorigin="anonymous"></script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- sidebar -->
    <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">LSP TELEMATIKA</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="../dashboard_admin.php">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="asesor/list_asesor.php" class="active">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span class="links_name">Asesor</span>
          </a>
        </li>
        <li>
          <a href="../list_asesi.php">
            <i class="fa-solid fa-users"></i>
            <span class="links_name">Asesi</span>
          </a>
        </li>
        <li>
          <a href="../skema/list_skema.php">
          <i class="fa-solid fa-folder-open"></i>
            <span class="links_name">Skema</span>
          </a>
        </li>
        <li>
          <a href="lsp_graph.php">
            <i class="fa-solid fa-chart-pie"></i>
            <span class="links_name">Graph</span>
          </a>
        </li>
        <li class="log_out">
          <a href="#">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
    </div>

    <section class="home-section">
        <!-- navigation -->
        <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <form method="get" class="search-box">
            <input type="text" name="search" placeholder="Search...">
            <i class='bx bx-search' ></i>
        </form>
        <div class="profile-details">
            <span class="admin_name">Prem Shahi</span>
            <i class='bx bx-chevron-down' ></i>
        </div>
        </nav>

        <div class="home-content">
            <div class="container px-5">
                <h1 class="text-center mb-5">Asesor Kompetensi LSP</h1>
                <ul><a href="create_asesor.php"
                    class="btn btn-link text-decoration-none rounded"
                    style="background-color: #1a5cd9; color: white">
                    <i class="bi bi-person-add"></i> Tambah Asesor</a>
                </ul>
                <table class="table table-bordered" style="font-size: 14px">
                    <thead class="table-info text-center">
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Email</th>
                            <th>Nomor Register BNSP</th>
                            <th>Masa Berlaku Sertifikat Asesor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $batas = 5; 
                        $halaman = $_GET['halaman'] ?? null;
            
                        if(empty($halaman)){
                            $posisi = 0; $halaman = 1;
                        }else{
                            $posisi = ($halaman-1) * $batas;
                        }

                        if(isset($_GET['search'])){ 
                            $search = mysqli_real_escape_string($conn, $_GET['search']); 
                            $sql="SELECT * FROM assessor WHERE assessor_name LIKE '%$search%' ORDER BY assessor_name ASC LIMIT $posisi, $batas"; 
                        }else{ 
                            $sql="SELECT * FROM assessor ORDER BY assessor_name ASC LIMIT $posisi, $batas";
                        }

                        // Retrieve data from the database
                        $hasil=mysqli_query($conn, $sql); 
                        while ($row = mysqli_fetch_assoc($hasil)) {
                        // Output data of each row
                            echo "<tr>
                            <td class='text-capitalize'>".$row["assessor_name"]."</td>
                            <td>".$row["nik_number"]."</td>
                            <td>".$row["email"]."</td>
                            <td>".$row["bnsp_reg_num"]."</td>
                            <td>".$row["exp_date_sertificate"]."</td>
                            <td class='text-center'>
                                <a href='detail_asesor.php?nik_number=" .$row['nik_number']."' data-bs-toggle='tooltip' data-bs-title='View Record' style='color: green'>
                                    <i class='fa-regular fa-eye'></i></a> 
                                <a href='update_asesor.php?nik_number=" .$row['nik_number']."' data-bs-toggle='tooltip' data-bs-title='Update Record'> 
                                    <i class='fa-regular fa-pen-to-square'></i></a> 
                                <a href='delete.php?nik_number=" .$row['nik_number']."' data-bs-toggle='tooltip' data-bs-title='Delete Record' style='color: red'>
                                    <i class='fa-solid fa-trash'></i></a>
                            </td>
                            </tr>";
                        }
                    ?>
                    </tbody>
                </table>
                
                <?php
                    if(isset($_GET['search'])){
                        $search= $_GET['search']; 
                        $query2="SELECT * FROM assessor WHERE assessor_name LIKE '%$search%' ORDER BY assessor_name ASC"; 
                    }else{ 
                        $query2="SELECT * FROM assessor ORDER BY assessor_name ASC";
                    }

                    $result2 = mysqli_query($conn, $query2); 
                    $jmldata = mysqli_num_rows($result2); 
                    $jmlhalaman = ceil($jmldata/$batas);
                ?>
                <br>
                <ul class="pagination container"> 
                    <?php 
                        for($i=1;$i<=$jmlhalaman; $i++) {
                            if ($i != $halaman) { 
                                if(isset($_GET['search'])){ 
                                    $search = $_GET['search'];
                                    echo "<li class='page-item'><a class='page-link' href='read.php?halaman=$i&search=$search'>
                                        $i</a></li>";
                                }else{ 
                                    echo "<li class='page-item'><a class='page-link' href='read.php?halaman=$i'>$i</a></li>";
                                }
                            } else {
                                echo "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
                            }
                        }
                    ?>
                </ul> 
            </div>
        </div>
    </section>

    <script src="../../../assets/js/script.js"></script>
</body>
</html>