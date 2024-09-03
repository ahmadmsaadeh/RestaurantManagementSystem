import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatestaffComponent } from './createstaff.component';

describe('CreatestaffComponent', () => {
  let component: CreatestaffComponent;
  let fixture: ComponentFixture<CreatestaffComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CreatestaffComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CreatestaffComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
