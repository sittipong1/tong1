<!DOCTYPE html>
<html>

<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootpag/1.0.7/jquery.bootpag.min.js"></script>
  
  
  
<script type="text/javascript">
    $(document).ready(function() {
        a();
        b();
        c();
      load_data();

      //สร้าง function รับค่า input
      $('#search_text').keyup(function() {

          var search = $(this).val();
          if (search != '') {

            load_data(search);//โหลดข้อมูล การค้นหา

          } else {

            load_data();

          }
      });
    });

    //function กำหนด page
    function createPagination(current, page) {

      // แก้ไข การเรียกซ้ำซ้อน
      $("#page-selection").unbind();

      $('#page-selection').bootpag({

        total: page,//หน้าทั้งหมด
        page: current,
        maxVisible: 6,
        leaps: false,
        next: '>>>',
        prev: '<<<'

      }).on('page', function(event, num) {

        var search_text = $("#search_text").val();

        console.log(num);

        load_data(search_text, num);

      });
    }

    function load_data(query = "", page = 1) {

      var data = {};
      data["query"] = query;
      data["page"] = page;

      var query = JSON.stringify(data);

      $.ajax({

        url: "name.php",
        method: "POST",
        async: false,// function จะทำงานเมือสมบูรแล้ว     
        data: {

          "query": query

        },
        dataType: "json",
        success: function(res) {

          var result = res.result;

          var html = "";
          result.forEach(ele => {
            
            html += "<tr>" +
              "<td width='100%' >" + ele.name + "</td>" +
              "<td ><button onclick='send(" + ele.invoice_id + ");' type='button'  name='butsave' id='show' >" +
              "<i class='fas fa-plus'></i></button>" +
              "</td>" +
              "</tr>" +
              "<tr id='invoiceBody" + ele.invoice_id + "' style='display:none' bgcolor='#FFFF99'>" +
              "<td colspan = '2' id ='invoiceBody" + ele.invoice_id + "' bgcolor='#FFFF99'>" +
              "</td></tr>";
          });

          $("#result").html(html);

          // load button
          createPagination(res.currentPage, res.page);

        }
      });
    }

    //function แสดงค่าตัว  invoice_item 
    function send(id) {

var x = document.getElementById("invoiceBody" + id);
// ajax
$.ajax({
  url: "data_name.php",
  type: "POST",
  data: 'id=' + id,
  success: function(data) {
    if (x.style.display === "none") {
      x.style.display = "block";
      $("#invoiceBody" + id).html(data)
    } else {
      x.style.display = "none";
    }

  }
});

}
</script>

<style>
    td,
    th {
      border: 2px solid;
      text-align: center;
      padding: 8px;

    }
</style>

</head>

<body>


  <div class="container">
    <div class="container">

       <input type="text" name="search_text" id="search_text" placeholder="Search " size="30" style="background-color:#F0FFFF;">

    </div>

    <div  style="padding-top:20px">
        <table width="30%">
          <thead>
            <tr>
              <th colspan = '2'>ชื่อ</th>
            </tr>
          </thesd>
          <tbody id="result">

          </tbody>
        </table>
    </div>

    <div class="container" id="page-selection"></div>

  </div>

</body>

</html>