import { ComponentFixture, TestBed } from '@angular/core/testing';

import { YearlySalesComponent } from './yearly-sales.component';

describe('YearlySalesComponent', () => {
  let component: YearlySalesComponent;
  let fixture: ComponentFixture<YearlySalesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ YearlySalesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(YearlySalesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
