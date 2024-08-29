import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReservationUserManagementComponent } from './reservation-user-management.component';

describe('ReservationUserManagmentComponent', () => {
  let component: ReservationUserManagementComponent;
  let fixture: ComponentFixture<ReservationUserManagementComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ReservationUserManagementComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ReservationUserManagementComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
