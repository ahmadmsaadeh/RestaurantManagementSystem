import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { MenuService } from '../menu.service';
import { Modal } from 'bootstrap';
@Component({
  selector: 'app-editlist',
  templateUrl: './editlist.component.html',
  styleUrls: ['./editlist.component.css']
})
export class EditlistComponent {
  menuItems: any[] = [];
  //selectedItem: any = null;
  isEditing: boolean = false;
  selectedItem: any = {};
  modalInstance: any;
  constructor(private menuService: MenuService, private router: Router) { }

  ngOnInit(): void {
    this.loadMenuItems();
  }


  loadMenuItems(): void {
    this.menuService.getAllMenuItems().subscribe(menuItems => {
      this.menuItems = menuItems;
      console.log('Loaded menu items:', this.menuItems); // Log menu items for debugging

    });
  }


  editMenuItem(item: any): void {
    this.selectedItem = { ...item };
    this.isEditing = true;

    const modalElement = document.getElementById('editModal');
    if (modalElement) {
      this.modalInstance = new Modal(modalElement);
      this.modalInstance.show();
    }
  }

  saveMenuItem(): void {
    if (this.selectedItem) {
      this.menuService.updateMenuItem(this.selectedItem.menu_item_id, this.selectedItem).subscribe({
        next: () => {
          console.log(`Successfully updated item with ID: ${this.selectedItem.menu_item_id}`);
          this.loadMenuItems();
          this.isEditing = false;
          alert('Menu item updated successfully.');

          // Close the modal after saving
          if (this.modalInstance) {
            this.modalInstance.hide();
          }
        },
        error: (err) => {
          console.error(`Error updating menu item with ID: ${this.selectedItem.menu_item_id}`, err);
          alert('Failed to update menu item.');
        }
      });
    }
  }


  cancelEdit(): void {
    this.isEditing = false;
    this.selectedItem = {};

  }
  // done ibtisamm // delete

  deleteMenuItem(menu_item_id: number): void {
    console.log(`Attempting to delete item with ID: ${menu_item_id}`);

    if (menu_item_id) {
      if (confirm('Are you sure you want to delete this item?')) {
        this.menuService.deleteMenuItem(menu_item_id).subscribe({
          next: () => {
            console.log(`Successfully deleted item with ID: ${menu_item_id}`);
            this.menuItems = this.menuItems.filter(item => item.menu_item_id !== menu_item_id);
            alert('Menu item deleted successfully.');
          },
          error: (err) => {
            console.error(`Error deleting menu item with ID: ${menu_item_id}`, err);
            alert('Failed to delete menu item.........');
          }
        });
      }
    } else {
      console.error('Invalid ID provided for deletion');
      alert('Invalid ID provided.');
    }
  }



}
