import { Component } from '@angular/core';
import {NgForm} from "@angular/forms";
import {CreateaccountService} from "./service/createaccount.service";

@Component({
  selector: 'app-createstaff',
  templateUrl: './createstaff.component.html',
  styleUrls: ['./createstaff.component.css']
})
export class CreatestaffComponent {
  public form: {
    username: string | null,
    firstname: string | null,
    lastname: string | null,
    phonenumber: string | null,
    email: string | null,
    password: string | null,
    role_id: number | null
  } = {
    username: null,
    firstname: null,
    lastname: null,
    phonenumber: null,
    email: null,
    password: null,
    role_id: null
  };

  public error: any = [];
  public msg: string | null = null;

  constructor(private createaccount: CreateaccountService) { }
  selectedValue: string = '';
  options = [
    { value: 'Kitchen Staff', label: 'Kitchen Staff' },
    { value: 'Wait Staff', label: 'Wait Staff' },
    { value: 'Bartender', label: 'Bartender' },
    { value: 'Dishwasher', label: 'Dishwasher' },
  ];

  ngOnInit(): void { }

  submitSignup(registrationForm: NgForm) {
    console.log(this.selectedValue);
    let role_id: number | null = null;

    if (this.selectedValue === "Kitchen Staff") {
      role_id = 4;
    } else if (this.selectedValue === "Wait Staff") {
      role_id = 5;
    } else if (this.selectedValue === "Bartender") {
      role_id = 6;
    } else if (this.selectedValue === "Dishwasher") {
      role_id = 7;
    }

   this.form.role_id = role_id;
    console.log('Form data before submit:', this.form);
    return this.createaccount.createstaff(this.form).subscribe(
      data => this.handleResponse(data, registrationForm),
      error => this.handleError(error)
    );
  }


  handleResponse(data: any, registrationForm: NgForm) {
    alert('Registration Success! Please click here to log in.');
    registrationForm.resetForm();
    window.location.href = '/createstaffaccount';
    console.log('Response data:', data);
    if (data.statusCode === 200) {
      registrationForm.resetForm();
    }

  }


  handleError(error: any) {
    console.error('Error response:', error);
    this.error = error.error.errors;
      alert(error.error.message);
  }
  protected status = status;
}
