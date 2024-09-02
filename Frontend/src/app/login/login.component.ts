import {Component, Input} from '@angular/core';
import {Router} from "@angular/router";
import * as bootstrap from 'bootstrap';
import {LoginService} from "../LoginService";
import {UserService} from "../userservice";



@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  constructor( private userService: UserService , private router: Router, private loginService: LoginService) {
  }

  ngAfterViewInit() {
    const carouselElement = document.querySelector('#carouselExampleIndicators');
    if (carouselElement) {
      new bootstrap.Carousel(carouselElement);
    }
  }

  email: string = '';
  password: string = '';
  @Input() UserType: String = '';

  onSubmit() {

    this.loginService.checklogin(this.email, this.password).subscribe(
      result => {
        if (result.success) {
          console.log('Login successful');
          if (result.role_id !== undefined) {
            this.loginService.usertype(result.role_id).subscribe(
              response => {
                console.log('Role retrieval response:', response);
                if (response.success) {
                  console.log('Role name:', response.role_name);
                  const UserType = response.role_name;
                  this.userService.setUserType(UserType);
                  this.router.navigate(['/side-with-content']);
                  if (response.role_name=="Admin") {}
                  else if (response.role_name=="Management") {}
                  else if (response.role_name=="Customer") {}
                  else if (response.role_name=="Kitchen Staff") {}
                  else if (response.role_name=="Cashier Staff") {}
                  else {}

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
        } else {
          console.log('Login not successful');
        }
      },
      error => {
        console.error('Error occurred during login', error);
        console.error('Error details:', error.error);  // Print the detailed error response
      }
    );
  }
  ngOnInit(): void {

    this.onSubmit();

  }

}
