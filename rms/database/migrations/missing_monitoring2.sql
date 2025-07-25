create
    definer = gfslan5_msts_rsm@localhost function missing_monitoring(container_id int, plug_on_day date, plug_on_time time) returns int
BEGIN
    DECLARE missing_count INT;
    DECLARE last_monitoring_day date;
    DECLARE loop_selected_date date;
    DECLARE finished int;

    #monitoring variables
    DECLARE rm_date date;
    DECLARE rm_schedule_4 varchar(50);
    DECLARE rm_schedule_8 varchar(50);
    DECLARE rm_schedule_12 varchar(50);
    DECLARE rm_schedule_16 varchar(50);
    DECLARE rm_schedule_20 varchar(50);
    DECLARE rm_schedule_24 varchar(50);

    #testing variable
    DECLARE flag tinyint;

    #Loop cursor - get all days between given to days.
    DECLARE all_days_cur CURSOR FOR select *
                                    from (select adddate(plug_on_day,
                                                         t4.i * 10000 + t3.i * 1000 + t2.i * 100 + t1.i * 10 + t0.i) selected_date
                                          from (select 0 i
                                                union
                                                select 1
                                                union
                                                select 2
                                                union
                                                select 3
                                                union
                                                select 4
                                                union
                                                select 5
                                                union
                                                select 6
                                                union
                                                select 7
                                                union
                                                select 8
                                                union
                                                select 9) t0,
                                               (select 0 i
                                                union
                                                select 1
                                                union
                                                select 2
                                                union
                                                select 3
                                                union
                                                select 4
                                                union
                                                select 5
                                                union
                                                select 6
                                                union
                                                select 7
                                                union
                                                select 8
                                                union
                                                select 9) t1,
                                               (select 0 i
                                                union
                                                select 1
                                                union
                                                select 2
                                                union
                                                select 3
                                                union
                                                select 4
                                                union
                                                select 5
                                                union
                                                select 6
                                                union
                                                select 7
                                                union
                                                select 8
                                                union
                                                select 9) t2,
                                               (select 0 i
                                                union
                                                select 1
                                                union
                                                select 2
                                                union
                                                select 3
                                                union
                                                select 4
                                                union
                                                select 5
                                                union
                                                select 6
                                                union
                                                select 7
                                                union
                                                select 8
                                                union
                                                select 9) t3,
                                               (select 0 i
                                                union
                                                select 1
                                                union
                                                select 2
                                                union
                                                select 3
                                                union
                                                select 4
                                                union
                                                select 5
                                                union
                                                select 6
                                                union
                                                select 7
                                                union
                                                select 8
                                                union
                                                select 9) t4) v
                                    where selected_date between plug_on_day and last_monitoring_day;
    #stop loop
    DECLARE CONTINUE HANDLER
        FOR NOT FOUND SET finished = 1;

    select reefer_monitorings.date
    into last_monitoring_day
    from reefer_monitorings
    where reefer_monitorings.container_id = container_id
    order by date desc
    limit 1;

    set missing_count = 0;

    #loop
    OPEN all_days_cur;
    getDate:
    LOOP
        FETCH all_days_cur into loop_selected_date;

        #read each monitoring date
        SELECT EXISTS(SELECT *
                      from reefer_monitorings
                      where reefer_monitorings.date = loop_selected_date
                        AND reefer_monitorings.container_id = container_id)
        into flag;

        if flag = true then
            SELECT reefer_monitorings.date,
                   reefer_monitorings.schedule_4,
                   reefer_monitorings.schedule_8,
                   reefer_monitorings.schedule_12,
                   reefer_monitorings.schedule_16,
                   reefer_monitorings.schedule_20,
                   reefer_monitorings.schedule_24
            INTO rm_date,
                rm_schedule_4,
                rm_schedule_8,
                rm_schedule_12,
                rm_schedule_16,
                rm_schedule_20,
                rm_schedule_24
            from reefer_monitorings
            where reefer_monitorings.date = loop_selected_date
              AND reefer_monitorings.container_id = container_id;


            #on plug on day
            if loop_selected_date = plug_on_day then
                if STR_TO_DATE('04:00', '%h:%i') > plug_on_time AND rm_schedule_4 is null then
                    set missing_count = missing_count + 1;
                end if;
                if STR_TO_DATE('08:00', '%h:%i') > plug_on_time AND rm_schedule_8 is null then
                    set missing_count = missing_count + 1;
                end if;
                if STR_TO_DATE('12:00', '%h:%i') > plug_on_time AND rm_schedule_12 is null then
                    set missing_count = missing_count + 1;
                end if;
                if STR_TO_DATE('16:00', '%h:%i') > plug_on_time AND rm_schedule_16 is null then
                    set missing_count = missing_count + 1;
                end if;
                if STR_TO_DATE('20:00', '%h:%i') > plug_on_time AND rm_schedule_20 is null then
                    set missing_count = missing_count + 1;
                end if;
                if STR_TO_DATE('23:59', '%h:%i') > plug_on_time AND rm_schedule_24 is null then
                    set missing_count = missing_count + 1;
                end if;

            elseif loop_selected_date = last_monitoring_day then #if last monitoring day.

                if rm_schedule_4 is null then
                    set missing_count = missing_count + 1;
                end if;

            else #any other day

                if rm_schedule_4 is null then
                    set missing_count = missing_count + 1;
                end if;
                if rm_schedule_8 is null then
                    set missing_count = missing_count + 1;
                end if;
                if rm_schedule_12 is null then
                    set missing_count = missing_count + 1;
                end if;
                if rm_schedule_16 is null then
                    set missing_count = missing_count + 1;
                end if;
                if rm_schedule_20 is null then
                    set missing_count = missing_count + 1;
                end if;
                if rm_schedule_24 is null then
                    set missing_count = missing_count + 1;
                end if;

            end if;

        else
            #missing
            set missing_count = missing_count + 1;
        end if;

        if finished = 1 then
            LEAVE getDate;
        end if;
    end loop;

    #return
    IF (missing_count > 0) THEN
        RETURN 1;
    ELSE
        RETURN 0;
    END IF;
END;

