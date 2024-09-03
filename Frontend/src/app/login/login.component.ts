import {Component, Input} from '@angular/core';
import {Router} from "@angular/router";
import * as bootstrap from 'bootstrap';
import {LoginService} from "./service/LoginService";
import {UserService} from "../dashboard/service/userservice";


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  constructor( private userService: UserService , private router: Router, private loginService: LoginService) {}

  ngAfterViewInit() {
    const carouselElement = document.querySelector('#carouselExampleIndicators');
    if (carouselElement) {
      new bootstrap.Carousel(carouselElement);
    }
  }

  email: string = '';
  password: string = '';
  @Input() UserType: String = '';
  @Input() Useremail: String = '';

  onSubmit() {
    this.loginService.checklogin(this.email, this.password).subscribe(
      result => {
        if (result.success) {

          console.log('Login successful');
          //alert('Login successful');
          if (result.role_id !== undefined) {
            this.loginService.usertype(result.role_id).subscribe(
              response => {
                console.log('Role retrieval response:', response);
                if (response.success) {
                  console.log('Role name:', response.role_name);
                  alert('Login successful, Welcome ' +response.role_name + '!');
                  const UserType = response.role_name;
                  this.userService.setUserType(UserType);
                  this.userService.setUseremail(this.email);
                  this.router.navigate(['/side-with-content/reports']);
                  if (response.role_name === "Admin") {
                  } else if (response.role_name === "Management") {

                  } else if (response.role_name === "Customer") {

                  } else if (response.role_name === "Kitchen Staff") {

                  } else if (response.role_name === "Cashier Staff") {

                  } else {
                  }

                } else {
                  console.log('Role name retrieval failed');
                }
              },
              error => {
                console.error('Error occurred during role name retrieval', error);
              }
            );
          } else {
            console.log('Role ID is undefined');
          }

          if (result.email !== undefined) {
            console.log('User email:', result.email);
            this.userService.setUseremail(result.email);
          } else {
            console.log('User email is undefined');
          }

        } else {
          console.log('Login not successful');
          alert('Login not successful');
        }
      },
      error => {
        console.error('Error occurred during login', error);
        console.error('Error details:', error.error);
      }
    );
  }

  ngOnInit(): void {
    this.onSubmit();
  }

}
