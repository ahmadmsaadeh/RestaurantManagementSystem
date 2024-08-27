import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private userType: string = '';

  setUserType(type: string) {
    this.userType = type;
  }

  getUserType(): string {
    return this.userType;
  }
}
