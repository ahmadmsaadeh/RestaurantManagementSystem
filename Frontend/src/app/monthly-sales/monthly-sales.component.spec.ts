import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MonthlySalesComponent } from './monthly-sales.component';

describe('MonthlySalesComponent', () => {
  let component: MonthlySalesComponent;
  let fixture: ComponentFixture<MonthlySalesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MonthlySalesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MonthlySalesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
