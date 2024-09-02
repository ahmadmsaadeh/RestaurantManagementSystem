import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private userType: string = '';
  private Useremail: string = '';
  setUserType(type: string) {
    this.userType = type;
  }
  getUserType(): string {
    return this.userType;
  }
  setUseremail(type: string) {
    this.Useremail = type;
  }
  getUseremail(): string{
    return this.Useremail;
  }

}
