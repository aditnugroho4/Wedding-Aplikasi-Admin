<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
		String.prototype.replaceAll = function(str1, str2, ignore) 
	{
		return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
	};
            var selectedId;
			$(document).ready(function () {
				$('a[href="#Support"]').attr('class','');
				$('a[href="#Support"]').attr('aria-expanded',true);
				$("#Support").attr('class','list-unstyled collapse show');
				$(document).ready(function () {
				$("#tblData").dataTable({
				    "bJQueryUI": true,
				    "bAutoWidth": true,
                    // "bProcessing": true,
                    "bServerSide": true,
                    "sPaginationType": "full_numbers",
                    "sAjaxSource": "<?php echo site_url('admin/get_data_table_source'); ?>?table=m_log&columns=,nama,m_log.ipaddress,action,m_log.date&fildjoins=,m_user.nama&jwhere=user_id&joins=m_user&exports=m_user",
                    "aoColumns" : [
                        { "sTitle" : "#", "mData" : "no", "bSortable" : false, "sClass" : "center" },
                        { "sTitle" : "User", "mData" : "nama" },
                        { "sTitle" : "Ipaddress", "mData" : "ipaddress" },
                        { "sTitle" : "Action", "mData" : "action" },
                        { "sTitle" : "Waktu", "mData" : "date" }
                    ]
				});
			}); 
		
		
}); 
	</script>