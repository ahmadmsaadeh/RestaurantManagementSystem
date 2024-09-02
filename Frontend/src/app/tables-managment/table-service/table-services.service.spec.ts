import { TestBed } from '@angular/core/testing';

import { TableServicesService } from './table-services.service';

describe('TableServicesService', () => {
  let service: TableServicesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TableServicesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
