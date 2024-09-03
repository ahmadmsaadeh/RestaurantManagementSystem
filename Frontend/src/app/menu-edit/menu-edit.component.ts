import { Component, OnInit  } from '@angular/core';
import { MenuService } from '../menu.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Observable, catchError, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-menu-edit',
  templateUrl: './menu-edit.component.html',
  styleUrls: ['./menu-edit.component.css']
})
export class MenuEditComponent{
  form: FormGroup;
  categories = [
    { id: 1, name: 'main' },  // main
    { id: 2, name: 'dessert' }     // dessert
  ];
  selectedCategoryId: number | undefined;
  selectedFile: File | undefined;

  constructor(private fb: FormBuilder, private http: HttpClient) {
    this.form = this.fb.group({
      itemName: ['', Validators.required],
      itemDescription: [''],
      itemPrice: ['', [Validators.required, Validators.min(0)]],
      itemCategory: ['', Validators.required],
      itemAvailability: [true, Validators.required],
      itemImage: [null]
    });
  }
 /* constructor(private fb: FormBuilder, private menuService: MenuService) {
    this.form = this.fb.group({
      itemName: ['', Validators.required],
      itemDescription: [''],
      itemPrice: ['', [Validators.required, Validators.min(0)]],
      itemCategory: ['', Validators.required],
      itemAvailability: [true, Validators.required],
      itemImage: [null]
    });
  }*/
  onCategoryChange(event: any): void {
    const categoryName = event.target.value;
    const category = this.categories.find(c => c.name === categoryName);
    this.selectedCategoryId = category ? category.id : undefined;

    // Update the form control for itemCategory
    this.form.get('itemCategory')?.setValue(categoryName);

    console.log('Selected Category ID:', this.selectedCategoryId);
  }

  /*onFileChange(event: any): void {
    const file = event.target.files[0];
    if (file) {
      this.selectedFile = file;
      console.log('Selected File:', this.selectedFile);

      // Store the file object directly in the form data
      this.form.get('itemImage')?.setValue(file);
    }
  }*/
  onFileChange(event: any): void {
    const file = event.target.files[0];
    if (file) {
      this.selectedFile = file;
      console.log('Selected File:', this.selectedFile);

      // Store only the filename in the form control
      this.form.get('itemImage')?.setValue(file.name);
    }
  }

  logFormData(formData: FormData) {
    // Convert FormData to a plain object and log it
    const object: any = {};
    formData.forEach((value, key) => {
      object[key] = value;
    });
    console.log('FormData content:', object);
  }

  onSubmit(): void {
    if (this.form.invalid) {
      console.error('Form is invalid');
      console.log('Form Values:', this.form.value);
      return;
    }

    if (!this.selectedCategoryId) {
      console.error('Category ID is undefined');
      return;
    }

    const formData = new FormData();
    formData.append('name_item', this.form.get('itemName')?.value);
    formData.append('description', this.form.get('itemDescription')?.value);
    formData.append('price', this.form.get('itemPrice')?.value);
    formData.append('category_id', this.selectedCategoryId.toString());
    formData.append('availability', this.form.get('itemAvailability')?.value ? '1' : '0');


   /* if (this.selectedFile) {
      formData.append('image', this.selectedFile);
    }*/

    if (this.selectedFile) {
      formData.append('image', this.selectedFile, this.form.get('itemImage')?.value);
    }

    this.logFormData(formData);
    this.http.post('http://localhost:8000/api/menu-items', formData).pipe(
      catchError(error => {
        console.error('Error adding menu item:', error);
        return of(error);
      })
    ).subscribe(response => {
      console.log('Menu item added successfully:', response);
    });

  /*  this.menuService.addMenuItem(formData).pipe(
      catchError(error => {
        console.error('Error adding menu item:', error);
        return of(error);
      })
    ).subscribe(response => {
      console.log('Menu item added successfully:', response);
    });*/
  }
}
