-- 1.3(e): function to show amount of money generated from customer billing 
-- start/end dates given as parameters

Create or Replace Function calcTotalBill (start_date IN TIMESTAMP, end_date IN TIMESTAMP)
RETURN DECIMAL
IS
l_bill DECIMAL := 0.00;					/* individual bill amounts */
l_total DECIMAL := 0.00;				/* total, initialised to 0 */
BEGIN
SELECT bill INTO l_bill FROM RepairLog
WHERE time_out >= start_date AND time_out <= end_date;
l_total := l_total + l_bill;
/* return total value */
RETURN l_total;
END;
/
Show errors;
