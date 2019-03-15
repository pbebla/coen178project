-- 1.3(e): function to show amount of money generated from customer billing 
-- start/end dates given as parameters
-- dates are given in TIMESTAMP format: 'dd-mmm-yy hh.mm.ss'

Create or Replace Function calcTotalBill (start_date IN TIMESTAMP, end_date IN TIMESTAMP)
RETURN DECIMAL
IS
l_bill DECIMAL := 0.00;					/* individual bill amounts */
l_total DECIMAL := 0.00;				/* total, initialised to 0 */
CURSOR Log_cur IS
(Select bill FROM RepairLog
WHERE time_out >= start_date AND time_out <= end_date);

BEGIN
-- NEED TO LOOP!!! vvv
OPEN Log_cur;
LOOP
FETCH Log_cur INTO l_bill;
	EXIT when Log_cur%notfound;
	l_total := l_total + l_bill;
END loop;
CLOSE Log_cur;
/* return total value */
RETURN l_total;
END;
/
Show errors;
