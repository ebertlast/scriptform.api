IF OBJECT_ID('SPS_IPS','P') IS NOT NULL DROP PROCEDURE SPS_IPS
GO
CREATE PROCEDURE DBO.SPS_IPS
(
	@Codigo_Med_BH    NVARCHAR(510) = NULL,
	@Codigo_Odo_BH    NVARCHAR(510) = NULL,
	@Mixto            BIT = NULL
)
WITH ENCRYPTION
AS
BEGIN
	
    SELECT *
    FROM [dbo].[VWS_IPS]
    WHERE   1=1
    AND     [Codigo_Med_BH] = CASE WHEN ISNULL(@Codigo_Med_BH ,'')='' THEN [Codigo_Med_BH] ELSE @Codigo_Med_BH END
    AND     [Codigo_Odo_BH] = CASE WHEN ISNULL(@Codigo_Odo_BH ,'')='' THEN [Codigo_Odo_BH] ELSE @Codigo_Odo_BH END
    AND     [Tipo] = CASE WHEN @Mixto IS NULL THEN [Tipo] ELSE CASE WHEN @Mixto = 1 THEN 'Mixto' ELSE 'INDEPENDIENTE PARA SERVICIO' END END
    ORDER BY [Regional], [Prestador_Medico], [Prestador_Odontologico]
END
GO
-- EXEC dbo.SPS_IPS @Mixto=0




