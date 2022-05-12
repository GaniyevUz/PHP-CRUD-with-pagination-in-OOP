<?php 
/**
 * @author Jakhongir Ganiev (https://ganiyev.uz)
 * @license MIT
 * @date 5/12/2022 09:17 AM
 */

require_once 'db_handler.php';

class employee extends db_handler {
	protected $emploees;
	public $offset = 0;
	public $per_page = 10;
	public $all_reconds;
	public $total_pages;

	//calculate the offset value of the next page
	public function offset($current_page){
		$this->offset = $this->per_page * ($current_page - 1);
		$this->all_records = $this->query("SELECT * FROM $this->table")->num_rows;
		$this->total_pages = ceil($this->all_records / $this->per_page);

	}

	//generating the list of people on table
	public function build(){
		$this->emploees = $this->fetch_all($this->per_page, $this->offset);
		if (!empty($this->emploees)) {
			$e = '';
			foreach ($this->emploees as $employee) {
				$e .= '<tr>';
				$e .= '<td>';
				$e .=	'<span>'.$employee['id'].'</span>';
				$e .=	'</td>';
				$e .=		'<td>' . $employee['name'] . '</td>';
				$e .=		'<td>' . $employee['email'] . '</td>';
				$e .=		'<td>' . $employee['address'] . '</td>';
				$e .=		'<td>' . $employee['phone'] . '</td>';
				$e .=		'<td>';
				$e .=	'<a href="#edit-'.$employee['id'].'" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
				$e .=	'<a href="#delete-'.$employee['id'].'" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
				$e .= '</td>';
				$e .= '</tr>';
			}
			return $e;
		}
	}

	//making modals for editing and deleting
	public function makeModal(){
		if (!empty($this->emploees)) {
			$m = '';
			foreach ($this->emploees as $employee) {
					// edit modal
				$m .= '<div id="edit-'.$employee['id'].'" class="modal fade">';
				$m .= '	<div class="modal-dialog">';
				$m .= '		<div class="modal-content">';
				$m .= '			<form action="" method="POST">';
				$m .= '				<div class="modal-header">';						
				$m .= '					<h4 class="modal-title">Edit Employee # '.$employee['id'].'</h4>';
				$m .= '					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
				$m .= '				</div>';
				$m .= '				<div class="modal-body">';
				$m .= '					<div class="form-group">';
				$m .= '						<label>Name</label>';
				$m .= '						<input type="text" class="form-control" name="name" value="'.$employee['name'].'">';
				$m .= '					</div>';
				$m .= '					<div class="form-group">';
				$m .= '						<label>Email</label>';
				$m .= '						<input type="email" class="form-control" name="email" value="'.$employee['email'].'">';
				$m .= '					</div>';
				$m .= '					<div class="form-group">';
				$m .= '						<label>Address</label>';
				$m .= '						<textarea class="form-control" name="address">'.$employee['address'].'</textarea>';
				$m .= '					</div>';
				$m .= '					<div class="form-group">';
				$m .= '						<label>Phone</label>';
				$m .= '						<input type="text" class="form-control" name="phone" value="'.$employee['phone'].'">';
				$m .= '					</div>';			
				$m .= '				</div>';
				$m .= '				<div class="modal-footer">';
				$m .= '					<input type="hidden" name="id" value="'.$employee['id'].'">';
				$m .= '					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
				$m .= '					<input type="submit" name="submit" class="btn btn-info" value="Save">';
				$m .= '				</div>';
				$m .= '			</form>';
				$m .= '		</div>';
				$m .= '	</div>';
				$m .= '</div>';

				 //  delete modal
				$m .= '<div id="delete-'.$employee['id'].'" class="modal fade">';
				$m .= '	<div class="modal-dialog">';
				$m .= '		<div class="modal-content">';
				$m .= '			<form action="" method="POST">';
				$m .= '				<div class="modal-header">';						
				$m .= '					<h4 class="modal-title">Delete '.$employee['name'].' ?</h4>';
				$m .= '					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
				$m .= '				</div>';
				$m .= '				<div class="modal-body">';					
				$m .= '					<h6>Are you sure you want to delete this Record?</h6>';
				$m .= '					<p class="text-warning">This action cannot be undone.</p>';
				$m .= '				</div>';
				$m .= '				<div class="modal-footer">';
				$m .= '					<input type="hidden" name="id" value="'.$employee['id'].'">';
				$m .= '					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">';
				$m .= '					<input type="submit" class="btn btn-danger" name="submit" value="Delete">';
				$m .= '				</div>';
				$m .= '			</form>';
				$m .= '		</div>';
				$m .= '	</div>';
				$m .= '</div>';	
			}
		}
			return $m;
	}

	// pagination 
	public function pagination($current_page){
		$all_records = $this->all_records;
		$per_page = $this->per_page;

				$page = '<div class="hint-text">Showing <b>'.$per_page.'</b> out of <b>'.$all_records.'</b> entries</div>';
					
				$pages = '<ul class="pagination">';
					// if current page will be greater than 1 it shows <- Previous text otherwise it wil be changed to disabled
				if($current_page > 1){
					$pages .= '<li class="page-item"><a href="?page=' . ($current_page - 1) . '" class="page-link">&laquo; Previous</a></li>';
				}else {
					$pages .= '<li class="page-item"><span class="page-link">&laquo; Previous</span></li>';
				}
					$win = 2; //window size
					$gap = false; // default value should be false
				for ($i=1; $i <= $this->total_pages; $i++) {
					//skipping long paginations and showing 3 buttons from first and last row and showing 2 buttons before the current page and after that as well
					if(abs($i - $current_page) > $win){
						if(!$gap)
 							$gap = true;
 						continue;
 					}

                            // indicating the current page and highlighting it
					if ($current_page == $i){
						$pages .= '<li class="page-item active"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
					}else{
						$pages .= '<li class="page-item"><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
					}

					$gap = false;
				}
				
					// if current page will be lower than total pages it shows Next -> text otherwise it wil be changed to disabled
				if($current_page < $this->total_pages){
					$pages .= '<li class="page-item"><a href="?page=' . ($current_page + 1) . '" class="page-link">Next &raquo</a></li>';
				}else {
					$pages .= '<li class="page-item"><span class="page-link">Next &raquo</span></li>';
				}
				$pages .= '</ul>';
			return $pages;
	}
}
