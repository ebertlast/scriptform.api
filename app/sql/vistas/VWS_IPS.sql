IF OBJECT_ID('VWS_IPS','V') IS NOT NULL DROP VIEW [dbo].[VWS_IPS]
GO
CREATE VIEW [dbo].[VWS_IPS]
AS
SELECT [Regional]
      ,[Municipio]
      ,[Departamento]
      ,[Codigo_Cda]
      ,[Prestador M�dico] AS Prestador_Medico
      ,[ID_Med]
      --,[Departamento1]
      ,[Codigo Med BH] AS Codigo_Med_BH
      ,[Direcci�n_Med] AS Direccion_Med
      ,[Telefono_Med]
      ,[Estado de la Asignaci�n_medica] AS Estado_de_la_Asignacion_medica
      ,[Prestador Odontol�gico] AS Prestador_Odontologico
      ,[ID_Odo] 
      ,[Codigo Odo BH] AS Codigo_Odo_BH
      ,[Direcci�n_odo] AS Direccion_Odo
      ,[Telefono_Odo]
      ,[Estado de la Asignaci�n Odontologica] Estado_Asignacion_Odontologica 
      ,[TIPO ] AS Tipo
      ,[Libre elecci�n Medicina] AS Libre_Eleccion_Medicina
      ,[Libre elecci�n Odontolog�a] AS Libre_Eleccion_Odontologia
  FROM [dbo].['IPS MD-OD$']
  WHERE Codigo_Cda IS NOT NULL
GO
--SELECT * FROM VWS_IPS
--ORDER BY Regional, Prestador_Medico, Prestador_Odontologico