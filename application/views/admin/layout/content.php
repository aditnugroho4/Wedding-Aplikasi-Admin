<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>    
<script type="text/javascript">

function getAge(dateString) {/* Fungsi Calculation Age*/
  var now = new Date();
  var today = new Date(now.getYear(),now.getMonth(),now.getDate());

  var yearNow = now.getYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();

  var dob = new Date(dateString.substring(0,4),dateString.substring(5,7)-1,dateString.substring(8,10));

  var yearDob = dob.getYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};
  var ageString = "";
  var yearString = "";
  var monthString = "";
  var dayString = "";


  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow -monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
      years: yearAge,
      months: monthAge,
      days: dateAge
      };

  if ( age.years > 1 ) yearString = " years";
  else yearString = " year";
  if ( age.months> 1 ) monthString = " months";
  else monthString = " month";
  if ( age.days > 1 ) dayString = " days";
  else dayString = " day";


  if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
		{tahun = age.years;
		bulan = age.months;
		hari = age.days;}
  else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
		{tahun = 0;
		bulan = 0;
		hari = age.days;}
  else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
		  {tahun = age.years;
			bulan = 0;
			hari = 0; }
  else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
		  { tahun = age.years;
				bulan = age.months;
		hari = 0;}
  else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
		{tahun = 0;
		bulan = age.months;
		hari = age.days;}
  else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
		{tahun = age.years;
		bulan = 0;
		hari = age.days;}
  else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
		{tahun = 0;
		bulan = age.months;
		hari = 0;}
  else {
		tahun = 0;
		bulan = age.months;
		hari = 0;}
  return;
}	
	
</script>    
<?php if($content){ $this->load->view($content);}?>
<!-- <?php echo $sidebar; ?> -->