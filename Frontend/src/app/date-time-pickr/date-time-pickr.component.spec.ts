import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DateTimePickrComponent } from './date-time-pickr.component';

describe('DateTimePickrComponent', () => {
  let component: DateTimePickrComponent;
  let fixture: ComponentFixture<DateTimePickrComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DateTimePickrComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DateTimePickrComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
